<?php

use App\Entity\TypeRessource;

$RESOURCE_TYPES = array_map(fn($case) => $case->value, TypeRessource::cases());

$TYPE_COLORS = [
  "Cours"            => ["bg" => "#1264a3", "text" => "#ffffff"],
  "TD"               => ["bg" => "#007a5a", "text" => "#ffffff"],
  "TP"               => ["bg" => "#1ba4c8", "text" => "#ffffff"],
  "Examen"           => ["bg" => "#4a154b", "text" => "#ffffff"],
  "Rapport"          => ["bg" => "#ecb22e", "text" => "#1d1c1d"],
  "Mémoire"          => ["bg" => "#611f69", "text" => "#ffffff"],
  "Exercice"         => ["bg" => "#e01e5a", "text" => "#ffffff"],
  "Présentation"     => ["bg" => "#2bac76", "text" => "#ffffff"],
  "Fiche de révision" => ["bg" => "#e8912d", "text" => "#ffffff"],
];

$GROUP_PALETTE = [
  "#1264a3",
  "#007a5a",
  "#611f69",
  "#e01e5a",
  "#4a154b",
  "#1ba4c8",
  "#2bac76",
  "#e8912d",
];

function groupColor($name)
{
  global $GROUP_PALETTE;
  $hash = 0;
  for ($i = 0; $i < strlen($name); $i++) {
    $hash = ord($name[$i]) + (($hash << 2) - $hash);
  }
  return $GROUP_PALETTE[abs($hash) % count($GROUP_PALETTE)];
}

function initials($name)
{
  $parts = explode(" ", $name);
  $init = "";
  foreach ($parts as $p) {
    $init .= $p[0] ?? "";
  }
  return strtoupper(substr($init, 0, 2));
}

function typeIconClass($type)
{
  switch ($type) {
    case "Cours":
      return "fa-book-open";
    case "Examen":
      return "fa-file-check";
    case "Présentation":
      return "fa-chalkboard";
    case "Mémoire":
    case "Rapport":
      return "fa-layer-group";
    default:
      return "fa-file-alt";
  }
}

function fileIconClass(?string $mimeType): string
{
  return match ($mimeType) {
    'application/pdf'                                                    => 'fa-file-pdf',
    'application/msword'                                                 => 'fa-file-word',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
    'application/vnd.ms-excel'                                           => 'fa-file-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'  => 'fa-file-excel',
    'application/vnd.ms-powerpoint'                                      => 'fa-file-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
    'image/jpeg', 'image/png', 'image/gif'                               => 'fa-file-image',
    'video/mp4'                                                          => 'fa-file-video',
    'application/zip', 'application/x-rar-compressed'                    => 'fa-file-archive',
    default                                                              => 'fa-file',
  };
}

function fileExtension(?string $mimeType): string
{
  return match ($mimeType) {
    'application/pdf'                                                    => 'PDF',
    'application/msword'                                                 => 'DOC',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'DOCX',
    'application/vnd.ms-excel'                                           => 'XLS',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'  => 'XLSX',
    'application/vnd.ms-powerpoint'                                      => 'PPT',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'PPTX',
    'image/jpeg'                                                         => 'JPEG',
    'image/png'                                                          => 'PNG',
    'image/gif'                                                          => 'GIF',
    'video/mp4'                                                          => 'MP4',
    'application/zip'                                                    => 'ZIP',
    'application/x-rar-compressed'                                       => 'RAR',
    default                                                              => 'FICHIER',
  };
}

function formatFileSize(?int $bytes): string
{
  if ($bytes === null) return '';
  if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' Mo';
  if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' Ko';
  return $bytes . ' o';
}
