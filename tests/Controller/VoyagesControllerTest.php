<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author 
 */
class VoyagesControllerTest extends WebTestCase {
    
    /**
     * test d'appel de page
     */
    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this->assertResponseIsSuccessful();
    }
    
    /**
     * méthode contrôlant le contenu d'une page
     */
    public function testContenuPage() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Tenerife');
    }
    
    /**
     * simulation d'un clicsur un lien de ville
     */
    public function testLinkVille() {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        // clic sur un lien (le nom d'une ville)
        $client->clickLink('Tenerife');
        // récupération du résultat du clic
        $response = $client->getResponse();
        // contôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/101', $uri);
    }
    
    /**
     * test formulaire de filtrage villes et pays
     */
    public function testFiltreVille() {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Tenerife'
        ]);
        // vérifie le nb de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la ville correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Tenerife');
    }
}
