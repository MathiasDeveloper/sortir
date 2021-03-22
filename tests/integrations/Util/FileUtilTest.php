<?php

use App\Util\FileUtil;
use PHPUnit\Framework\TestCase;

class fileUtilTest extends TestCase
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
    }

    public function testReadCsvToArray()
    {
    }

    public function testReadEmptyCsvToArray()
    {
    }
}
