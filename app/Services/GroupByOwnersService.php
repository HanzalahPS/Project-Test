<?php

namespace App\Services;

class GroupByOwnersService
{
    public function groupFilesByOwners($files)
    {
        $groupedFiles = [];

        foreach ($files as $file => $owner) {
            if (!isset($groupedFiles[$owner])) {
                $groupedFiles[$owner] = [];
            }
            $groupedFiles[$owner][] = $file;
        }

        return $groupedFiles;
    }
}
