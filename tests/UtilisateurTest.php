<?php
use PHPUnit\Framework\TestCase;
use App\Models\Utilisateur;
use App\Models\Database;

class UtilisateurTest extends TestCase
{
    private $utilisateur;
    private $pdoMock;
    private $sthMock;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->sthMock = $this->createMock(PDOStatement::class);

        $this->pdoMock->method('prepare')->willReturn($this->sthMock);
        
        $this->utilisateur = $this->getMockBuilder(Utilisateur::class)
                                  ->setMethods(['connect', 'close'])
                                  ->getMock();

        $this->utilisateur->dbh = $this->pdoMock;
    }

    public function testAdd()
    {
        $this->sthMock->expects($this->once())->method('execute')->willReturn(true);

        $data = ['John', 'Doe', 'Bio', 'john@example.com', '1234567890', 'password', 'path/to/profile.jpg', 1, 2];
        $this->utilisateur->add($data);
        
        $this->assertTrue(true);
    }

    public function testRemove()
    {
        $this->sthMock->expects($this->once())->method('execute')->with([$this->equalTo(1)])->willReturn(true);

        $this->utilisateur->remove(1);
        
        $this->assertTrue(true);
    }

    public function testUpdate()
    {
        $this->sthMock->expects($this->once())->method('execute')->willReturn(true);

        $data = ['John', 'Doe', 'Updated Bio', 'john@example.com', '1234567890', 'newpassword', 'path/to/new_profile.jpg', 1, 2, 1];
        $this->utilisateur->update($data);
        
        $this->assertTrue(true);
    }

    public function testGet()
    {
        $this->sthMock->method('execute')->willReturn(true);
        $this->sthMock->method('fetch')->willReturn(['nom' => 'John', 'prenom' => 'Doe']);

        $result = $this->utilisateur->get(['nom', 'prenom'], 'id_utilisateur', 1);
        
        $this->assertNotEmpty($result);
        $this->assertEquals('John', $result['nom']);
        $this->assertEquals('Doe', $result['prenom']);
    }

    public function testGetAll()
    {
        $this->sthMock->method('execute')->willReturn(true);
        $this->sthMock->method('fetchAll')->willReturn([
            ['id_utilisateur' => 1, 'nom' => 'John', 'prenom' => 'Doe', 'email' => 'john@example.com']
        ]);

        $result = $this->utilisateur->getAll([]);
        
        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
        $this->assertEquals('John', $result[0]['nom']);
    }
}
