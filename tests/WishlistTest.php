<?php

use PHPUnit\Framework\TestCase;
use App\Models\Wishlist;
use App\Models\Database;

class WishlistTest extends TestCase
{
    private $wishlist;

    protected function setUp(): void
    {
        // Création de l'instance de Wishlist
        $this->wishlist = new Wishlist();
    }

    public function testAddWish()
    {
        // Test simple pour vérifier si la méthode addWish retourne bien un résultat
        $result = $this->wishlist->addWish([1, 2]);
        $this->assertIsBool($result, 'Le retour de addWish devrait être un booléen');
    }

    public function testRemoveWish()
    {
        // Test simple pour vérifier si la méthode removeWish retourne bien un résultat
        $result = $this->wishlist->removeWish([1, 2]);
        $this->assertIsBool($result, 'Le retour de removeWish devrait être un booléen');
    }

    public function testGet()
    {
        // Test simple pour vérifier si la méthode get retourne bien un tableau
        $result = $this->wishlist->get(1,1);
        $this->assertIsArray($result, 'La méthode get doit retourner un tableau');
    }

    public function testGetAll()
    {
        // Test simple pour vérifier si la méthode getAll retourne bien un tableau
        $result = $this->wishlist->getAll(1);
        $this->assertIsArray($result, 'La méthode getAll doit retourner un tableau');
    }

    public function testAddWishFailure()
    {
        // Test si la méthode addWish retourne false lorsqu'elle échoue
        $result = $this->wishlist->addWish([99999, 2]);
        $this->assertFalse($result, 'addWish devrait retourner false en cas d\'échec');
    }

    public function testRemoveWishFailure()
    {
        // Test si la méthode removeWish retourne false lorsqu'elle échoue
        $result = $this->wishlist->removeWish([99999, 2]);
        $this->assertFalse($result, 'removeWish devrait retourner false en cas d\'échec');
    }
}
