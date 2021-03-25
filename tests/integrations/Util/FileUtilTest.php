<?php

namespace App\Tests\Integrations\Util;

use App\Util\FileUtil;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\InvalidDataSetException;

class FileUtilTest extends TestCase
{
    use FileUtil;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIsValid()
    {
        $obj = $this->getObjectForTrait(FileUtil::class);
        assertTrue($obj->exist(__DIR__ . '/../../fixtures/csv/valid_participant.csv'));
    }

    public function testIsNotValidNByNotReadable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getObjectForTrait(FileUtil::class)
            ->exist(__DIR__ . '/../../fixtures/csv/not_valid_by_corrupt.csv');
    }

    public function testShouldExist()
    {
        $obj = $this->getObjectForTrait(FileUtil::class);
        assertTrue($obj->exist(__DIR__ . '/../../fixtures/csv/valid_participant.csv'));
    }

    public function testShouldNotExist()
    {
        $this->expectException(FileNotFoundException::class);
        $this->getObjectForTrait(FileUtil::class)
            ->exist(__DIR__ . '/../../fixtures/csv/paper_street_file.csv');
    }

    public function testHasValidHeader()
    {
        $obj = $this->getObjectForTrait(FileUtil::class);
        $this->assertTrue($obj->exist(__DIR__ . '/../../fixtures/csv/valid_participant.csv'));
    }

    public function testHasNotValidHeader()
    {
        $obj = $this->getObjectForTrait(FileUtil::class);
        $this->assertTrue($obj->exist(__DIR__ . '/../../fixtures/csv/not_valid_header_participant.csv'));
    }


    public function testReadCsvToArray()
    {
        $obj = $this->getObjectForTrait(FileUtil::class);
        $obj->readCsvToArray(__DIR__ . '/../../fixtures/csv/valid_participant.csv');
    }

    public function testReadEmptyCsvToArray()
    {
        $this->expectException(InvalidDataSetException::class);
        $this->getObjectForTrait(FileUtil::class)
            ->readCsvToArray(__DIR__ . '/../../fixtures/csv/not_valid_by_empty.csv');
    }
}
