<?php

namespace App\Tests;

use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author 
 */
class VisiteTest extends TestCase {
    
    /**
     * test unitaire sur la méthode getDatecreationString
     */
    public function testGetDatecreationString() {
        $visite = new Visite();
        $visite->setDatecreation(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }
}
