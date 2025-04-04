<?php
use PHPUnit\Framework\TestCase;
use App\Models\Contrat;
use App\Models\Database;

class ContratTest extends TestCase {
    private $contrat;

    protected function setUp(): void {
        // On crée une instance de la classe Contrat
        $this->contrat = new Contrat();

        // Optionnel : Configurer une base de données en mémoire pour les tests, si nécessaire
        // Cela peut être utile pour ne pas interagir avec une vraie base de données de production
        // Exemple pour SQLite (si tu as configuré cela dans ton projet)
        $this->contrat->setDbConnection(new Database('sqlite::memory:'));
    }

    public function testGetReturnsArray() {
        // Ajoutons un enregistrement fictif dans la base de données (si nécessaire)
        $this->contrat->getDbConnection()->exec("INSERT INTO secteur (id_secteur, nom) VALUES (1, 'IT')");
        
        // Appel de la méthode get avec un ID de 1
        $result = $this->contrat->get(1);
        
        // Vérifie que le résultat est bien un tableau
        $this->assertIsArray($result);
        
    }
}
