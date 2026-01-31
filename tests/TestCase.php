<?php


namespace RhysLeesLtd\Camelot\Tests;

use RhysLeesLtd\Camelot\Tests\Helpers\CsvAssertions;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use CsvAssertions;

    public function file($path)
    {
        return __DIR__ . '/files/' . $path;
    }
}