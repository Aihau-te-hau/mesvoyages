<?php

namespace App\Tests;

use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;
use App\Entity\Environment;

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
        $visite->setDatecreation(new DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }
    
    
    public function testAddEnvironnement() {
        $environnement = new Environment();
        $environnement->setNom("plage");
        $visite = new Visite();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementAvant = $visite->getEnvironnements()->count();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementAprès = $visite->getEnvironnements()->count();
        $this->assertEquals($nbEnvironnementAvant,
                $nbEnvironnementAprès, "ajout même environnement devrait échouer");
    }
}
