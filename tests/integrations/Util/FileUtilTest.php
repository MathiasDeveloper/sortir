<?php

namespace App\Tests\Integrations\Util;

use App\Util\FileUtil;
use PHPUnit\Framework\TestCase;

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

    public function testIsNotValidNByNotFile()
    {
    }

    public function testIsNotValidNByNotReadable()
    {
    }

    public function testShouldExist()
    {
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
    }

    public function testReadEmptyCsvToArray()
    {
    }
}
