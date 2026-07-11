<?php

namespace App\services;

use App\config\Session;
use App\Entity\Ressource;
use App\Entity\TypeRessource;
use App\Entity\Visibilite;
use App\repository\FavoriRepo;
use App\repository\MatiereRepo;
use App\repository\MembreRepo;
use App\repository\RessourceRepo;

class RessourceService
{
    private RessourceRepo $ressourceRepo;
    private MembreRepo $membreRepo;
    private MatiereRepo $matiereRepo;

    private const ALLOWED_MIMES = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'mp4'  => 'video/mp4',
        'zip'  => 'application/zip',
        'rar'  => 'application/x-rar-compressed',
    ];

    private const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50 MB
    private const UPLOAD_DIR = 'ressources';

    public function __construct()
    {
        $this->ressourceRepo = new RessourceRepo();
        $this->membreRepo = new MembreRepo();
        $this->matiereRepo = new MatiereRepo();
    }

    public function createRessource(array $data, ?array $file = null): array
    {
        $user = Session::getCurrentUser();
        if (!$user) {
            return ['success' => false, 'errors' => ['Vous devez être connecté.']];
        }

        $matiereId = !empty($data['matiere_id']) ? (int)$data['matiere_id'] : null;
        $groupeId = !empty($data['group_id']) ? (int)$data['group_id'] : 0;

        $ressource = Ressource::create(
            $data['title'],
            $data['description'],
            $matiereId,
            TypeRessource::from($data['type']),
            $user->getId(),
            $groupeId
        );

        $visibilite = $data['visibility'] ?? 'Public';
        $ressource->setVisibilite(Visibilite::from($visibilite));

        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $result = $this->handleFileUpload($file);
            if (!$result['success']) {
                return $result;
            }
            $ressource->setFilepath($result['filepath']);
            $ressource->setOriginalName($result['original_name']);
            $ressource->setFileSize($result['file_size']);
            $ressource->setMimeType($result['mime_type']);
        }

        $inserted = $this->ressourceRepo->insert($ressource);
        if (!$inserted) {
            return ['success' => false, 'errors' => ['Erreur lors de l\'enregistrement.']];
        }

        return ['success' => true];
    }

    private function handleFileUpload(array $file): array
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'errors' => [$this->uploadErrorToMessage($file['error'])]];
        }

        if ($file['size'] > self::MAX_FILE_SIZE) {
            return ['success' => false, 'errors' => ['Le fichier dépasse la limite de 50 Mo.']];
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $extension = array_search($mimeType, self::ALLOWED_MIMES, true);
        if ($extension === false) {
            return ['success' => false, 'errors' => ['Type de fichier non autorisé.']];
        }

        $storedName = bin2hex(random_bytes(16)) . '.' . $extension;
        $relativePath = self::UPLOAD_DIR . '/' . $storedName;
        $absolutePath = dirname(__DIR__, 2) . '/src/public/' . $relativePath;

        if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
            return ['success' => false, 'errors' => ['Erreur lors du déplacement du fichier.']];
        }

        return [
            'success' => true,
            'filepath' => $relativePath,
            'original_name' => $file['name'],
            'file_size' => $file['size'],
            'mime_type' => $mimeType,
        ];
    }

    private function uploadErrorToMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE   => 'Le fichier dépasse la limite autorisée par le serveur.',
            UPLOAD_ERR_FORM_SIZE  => 'Le fichier dépasse la limite du formulaire.',
            UPLOAD_ERR_PARTIAL    => 'Le fichier n\'a été que partiellement téléchargé.',
            UPLOAD_ERR_NO_FILE    => 'Aucun fichier sélectionné.',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Échec d\'écriture du fichier sur le disque.',
            UPLOAD_ERR_EXTENSION  => 'Téléchargement arrêté par une extension.',
            default               => 'Erreur de téléchargement inconnue.',
        };
    }

    public function getRessourceById(int $id): ?Ressource
    {
        return $this->ressourceRepo->selectById($id);
    }

    public function getRessourcesByGroup(int $groupeId): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];

        $membre = $this->membreRepo->selectByGroupeUser($user->getId(), $groupeId);
        if (!$membre) return [];

        return $this->ressourceRepo->getRessourceByGroup($groupeId);
    }

    public function getRessourcesByCurrentUser(): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];
        return $this->ressourceRepo->getRessourceByUser($user->getId());
    }

    public function getPublicRessources(): array
    {
        return $this->ressourceRepo->getPublicRessources();
    }

    public function hydrateRessources(array $ressources): array
    {
        $favoriRepo = new FavoriRepo();
        $favoriIds = [];
        if (Session::isConnected()) {
            $user = Session::getCurrentUser();
            if ($user) {
                $favoriIds = $favoriRepo->getFavoriIdsByUser($user->getId());
            }
        }
        foreach ($ressources as $r) {
            $r->setIsFavori(in_array($r->getId(), $favoriIds));
        }
        return $ressources;
    }

    public function getAllMatieres(): array
    {
        return $this->matiereRepo->selectAll();
    }
}
