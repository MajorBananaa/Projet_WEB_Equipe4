<?php

use PHPUnit\Framework\TestCase;
use App\Models\Evaluation;
use App\Models\Database;

class EvaluationTest extends TestCase
{
    private $evaluation;

    protected function setUp(): void
    {
        // Créer une instance de la classe Evaluation avant chaque test
        $this->evaluation = new Evaluation();
    }

    // Test pour ajouter une évaluation
    public function testAdd()
    {
        $data = ['4.5', 1, 1]; // Remplacer avec une note, un id_utilisateur, un id_entreprise
        $result = $this->evaluation->add($data);

        // Vérifier si l'ajout a réussi
        $this->assertIsTrue($result, "L'ajout de l'évaluation a échoué.");
    }

    // Test pour supprimer une évaluation
    public function testRemoveEval()
    {
        $id = [1, 1]; // Remplacer par un id_utilisateur, id_entreprise
        $result = $this->evaluation->removeEval($id);

        // Vérifier si la suppression a réussi
        $this->assertTrue($result, "La suppression de l'évaluation a échoué.");
    }

    // Test pour récupérer une évaluation par son id
    public function testGet()
    {
        $id = 1; // Remplacer avec un ID d'évaluation existante
        $result = $this->evaluation->get($id);

        // Vérifier si l'évaluation existe et est retournée correctement
        $this->assertIsArray($result, "Le résultat doit être un tableau.");
        $this->assertNotEmpty($result, "L'évaluation n'a pas été trouvée.");
        $this->assertObjectHasAttribute('id_eval', $result[0], "L'évaluation retournée doit avoir un id_eval.");
    }

    // Test pour récupérer toutes les évaluations pour un utilisateur
    public function testGetAll()
    {
        $id = 1; // Remplacer avec un id_utilisateur valide
        $result = $this->evaluation->getAll($id);

        // Vérifier si des évaluations sont retournées pour cet utilisateur
        $this->assertIsArray($result, "Le résultat doit être un tableau.");
        $this->assertGreaterThan(0, count($result), "Il n'y a pas d'évaluations pour cet utilisateur.");
    }
}
