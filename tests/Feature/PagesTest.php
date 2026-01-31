<?php


namespace RhysLeesLtd\Camelot\Tests\Feature;

use RhysLeesLtd\Camelot\Camelot;
use RhysLeesLtd\Camelot\Tests\TestCase;

class PagesTest extends TestCase
{
    /**
     * @test
     */
    public function can_set_pages_raw()
    {
        $camelot = Camelot::lattice('foo.pdf')->pages($pages = '1-2,4,5-end');

        $this->assertEquals($pages,$camelot->getPages());
    }

}