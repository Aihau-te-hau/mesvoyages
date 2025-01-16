<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author 
 */
class VisiteValidationsTest extends KernelTestCase {
    
    /**
     * test d'intégration de l'entity Visite
     * @return Visite
     */
    public function getVisite(): Visite {
        return (new Visite())
            ->setVille("New York")
            ->setPays("USA");
    }
    
    /**
     * assertion de comptage pour comparer le nombre d'erreurs obtenu 
     * (nombre d'éléments du tableau $error) avec le nombre d'erreurs attendu (valeur entière)
     */
    public function testValidNoteVisite() {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);
    }
    
    /**
     * fonction gérant l'appel au kernel et à assertCount
     * @param Visite $visite
     * @param int $nbErreursAttendues
     * @param string $message
     */
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    /**
     * test d'intégration d'une note invalide
     */
    public function testNonValidNoteVisite() {
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1);
    }
    
    /**
     * test de comparaison entre tempmin et tempmax
     * on veut tempmax > tempmin
     */
    public function testNonValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
}
