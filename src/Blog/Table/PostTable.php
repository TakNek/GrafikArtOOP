<?php
namespace App\Blog\Table;

class PostTable
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Pagine les articles
     *
     * @return array de stdClass
     */
    public function findPaginated() : array
    {
        return $this->pdo
                        ->query('SELECT * FROM posts ORDER BY id DESC LIMIT 10')
                        ->fetchAll();
    }

    /**
     * Récupère un article apartir de son id
     *
     * @param integer $id
     * @return \stdClass
     */
    public function find(int $id) : \stdClass
    {
        
        $query = $this->pdo->prepare('SELECT * from posts WHERE id= ?');
        $query->execute([$id]);
        return $query->fetch();
    }
}
