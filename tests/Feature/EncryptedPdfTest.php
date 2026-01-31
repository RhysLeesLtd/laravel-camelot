<?php


namespace RhysLeesLtd\Camelot\Tests\Feature;

use RhysLeesLtd\Camelot\Camelot;
use RhysLeesLtd\Camelot\Exceptions\PdfEncryptedException;
use RhysLeesLtd\Camelot\Tests\TestCase;

class EncryptedPdfTest extends TestCase
{
    /**
     * @test
     */
    public function fails_if_trying_to_read_encrypted_pdf_without_password()
    {
        $this->expectException(PdfEncryptedException::class);
        Camelot::lattice($this->file('health_protected.pdf'))->extract();
    }

    /**
     * @test
     */
    public function can_set_password_to_read_encrypted_pdf()
    {
        $tables = Camelot::lattice($this->file('health_protected.pdf'))
            ->password('ownerpass')
            ->extract();

        $this->assertCount(1, $tables);
    }
}