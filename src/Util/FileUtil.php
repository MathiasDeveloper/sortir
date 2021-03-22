<?php

namespace App\Util;

use _HumbugBox373c0874430e\Nette\FileNotFoundException;
use _HumbugBox373c0874430e\Symfony\Component\Console\Exception\InvalidArgumentException;

trait FileUtil
{
    public function isValid($filename): bool
    {
        if (! is_file($filename) || ! is_readable($filename)) {
            throw new InvalidArgumentException("Fichier d\'import non valide.");
        }

        return true;
    }

    public function exist($filename): bool
    {
        if (! file_exists($filename)) {
            throw new FileNotFoundException("Fichier d\'import non trouvé.");
        }

        return true;
    }

    public function write()
    {
        echo 'write';
    }

    public function hasValidParticipantHeader($fileName): bool
    {
        $participantHeader = [
            'user_name', 'last_name', 'first_name', 'phone', 'email', 'password', 'administrator', 'active', 'role', 'registration_date', 'site', ];

        $f = fopen($fileName, 'r');
        $fileHeader = str_getcsv(trim(fgets($f)), ';', '"');
        fclose($f);

        return $fileHeader == $participantHeader;
    }

    public function readCsvToArray($filename): array
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (! $header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
