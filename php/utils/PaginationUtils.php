<?php

namespace Utils;

class PaginationUtils
{
    public static function paginate(array $items, int $page, int $perPage): array
    {
        $totalItems = count($items);
        $totalPages = ceil($totalItems / $perPage);
        $page = max(1,  min($page, $totalPages));
        $offset = ($page - 1) * $perPage;
        return array_slice($items, $offset, $perPage);
    }
}
