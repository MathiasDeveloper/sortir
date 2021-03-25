<?php

namespace App\Util;

use _HumbugBox373c0874430e\Nette\FileNotFoundException;
use _HumbugBox373c0874430e\Symfony\Component\Console\Exception\InvalidArgumentException;
use PHPUnit\Util\InvalidDataSetException;
use App\Exception\Util;

trait FileUtil
{
    /**
     * @param $filename
     * @return bool
     * @throws Util\InvalidArgumentException
     */
    public function isValid($filename): bool
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new Util\InvalidArgumentException("Fichier d\'import non valide.");
        }

        return true;
    }

    /**
     * @param $filename
     * @return bool
     * @throws Util\FileNotFoundException
     */
    public function exist($filename): bool
    {
        if (!file_exists($filename)) {
            throw new Util\FileNotFoundException("Fichier d\'import non trouvé.");
        }

        return true;
    }


    public function write()
    {
        echo 'write';
    }

    /**
     * @param $fileName
     * @return bool
     * @throws Util\FileNotFoundException
     */
    public function hasValidParticipantHeader($fileName): bool
    {
        $participantHeader = [
            'user_name',
            'last_name',
            'first_name',
            'phone',
            'email',
            'password',
            'administrator',
            'active',
            'role',
            'registration_date',
            'site',
        ];


        if (false === ($file = fopen($fileName, 'r'))) {
            throw new Util\FileNotFoundException(sprintf('File : %s not exist', $file));
        }
        $fileHeader = str_getcsv(trim(fgets($file)), ';', '"');
        fclose($file);

        return $fileHeader == $participantHeader;
    }

    /**
     * @param $filename
     * @return array
     * @throws Util\EmptyFileException
     */
    public function readCsvToArray($filename): array
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        if ($data == null) {
            throw new Util\EmptyFileException(sprintf('data : %s or null is empty', $data));
        }

        return $data;
    }
}
