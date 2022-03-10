<?php
namespace Sergejandreev\Blankphp\Repositories;
use PDO;
use Sergejandreev\Blankphp\Entities\AbstractEntity;

abstract class AbstractRepository
{
    protected PDO $db;

    /**
     * AbstractRepository constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    abstract public function findAll();

    abstract public function findById($id);

    abstract public function create(AbstractEntity $entity);

    abstract public function update(AbstractEntity $entity);

    abstract public function delete(AbstractEntity $entity);
}