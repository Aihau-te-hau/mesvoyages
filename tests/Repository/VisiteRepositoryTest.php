<?php

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteRepositoryTest
 *
 * @author 
 */
class VisiteRepositoryTest extends KernelTestCase {
    
    /**
     * méthode qui récupère l'instance du repository
     * @return VisiteRepository
     */
    public function recupRepository(): VisiteRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }
    
    /**
     * méthode qui récupère le nb d'enregistrements dans la table Visite
     */
    public function testNbVisites() {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(2, $nbVisites);
    }
    
    /**
     * méthode initialisant un objet de type Visite
     * @return Visite
     */
    public function newVisite(): Visite {
        $visite = (new Visite())
                ->setVille("New York")
                ->setPays("USA")
                ->setDatecreation(new \DateTime("now"));
        return $visite;
    }
    
    /**
     * test de la méthode add de VisiteRepository
     */
    public function testAddVisite() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    /**
     * méthode qui va tester la suppression d'une visite
     */
    public function testRemoteVisite() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    /**
     * test de la méthode findByEqualValue
     */
    public function testFindByEqualValue() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", "New York");
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
        $this->assertEquals("New York", $visites[0]->getVille());
    }
}
