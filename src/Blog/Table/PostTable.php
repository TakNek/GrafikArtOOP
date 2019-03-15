<?php
namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Pagerfanta\Pagerfanta;
use Framework\Database\PaginatedQuery;

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
    public function findPaginated(int $perPage, int $currentPage) : Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY created_at desc',
            'SELECT COUNT(id) FROM posts ',
            Post::class
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * Récupère un article apartir de son id
     *
     * @param integer $id
     * @return \stdClass
     */
    public function find(int $id) : Post
    {
        
        $query = $this->pdo->prepare('SELECT * from posts WHERE id= ?');
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch();
    }


    /**
     * Met à jour un tuple au niveau de la BDD
     *
     * @param integer $id
     * @param array $params
     * @return boolean
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params['id'] = $id;
        $statement = $this->pdo->prepare("UPDATE posts SET $fieldQuery  WHERE id = :id");
        return $statement->execute($params);
    }

    /**
     * Crée un tuple dans la Table
     *
     * @param array $params
     * @return void
     */
    public function insert(array $params)
    {
        $fields = array_keys($params);
        $values = array_map(function ($field) {
            return ':'.$field;
        }, $fields);
        $statement = $this->pdo->prepare("INSERT INTO posts(".join(',', $fields).")  VALUES(".join(',', $values).")");
        return $statement->execute($params);
    }

    /**
     * Permet de Delete un tuple ... duh
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id) :bool
    {
        $statement = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
        return $statement->execute(['id' => $id]);
    }
    private function buildFieldQuery(array $params)
    {
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
