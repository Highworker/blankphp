<?php
namespace Sergejandreev\Blankphp\Repositories;
use PDO;
use Sergejandreev\Blankphp\Entities\AbstractEntity;
use Sergejandreev\Blankphp\Entities\Ingridient;

class IngridientRepository extends AbstractRepository
{

    /**
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->db->query('SELECT * FROM ingridients');
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ingridient = new Ingridient();
            $ingridient
                ->setId($result['id'])
                ->setName($result['name'])
                ->setDescription($result['description'])
            ;
            $ingridients[] = $ingridient;
        }
        return $ingridients;
    }

    /**
     * @param int $id
     *
     * @return Ingridient
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare(
            'SELECT
                id,
                name,
                description
            FROM ingridients
            WHERE id = :id
            LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $ingridient = new Ingridient();
        $ingridient
            ->setId($result['id'])
            ->setName($result['name'])
            ->setDescription($result['description'])
        ;
        return $ingridient;
    }

    /**
     * @param Ingridient $ingridient
     *
     * @return int
     */
    public function create(AbstractEntity $ingridient)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO ingridients (
                name,
                description         
            ) VALUES (
                :name,
                :description
            )'
        );
        $stmt->bindValue(':name', $ingridient->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $ingridient->getDescription(), PDO::PARAM_STR);
        $stmt->execute();

        $id = $this->db->lastInsertId();
        $ingridient->setId($id);
        return $id;
    }

    /**
     * @param Ingridient $ingridient
     *
     * @return bool
     */
    public function update(AbstractEntity $ingridient)
    {
        $stmt = $this->db->prepare(
            'UPDATE ingridients SET
                name = :name,
                description = :description
            WHERE id = :id'
        );
        $stmt->bindValue(':id', $ingridient->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $ingridient->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $ingridient->getDescription(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param Ingridient $ingridient
     *
     * @return bool
     */
    public function delete(AbstractEntity $ingridient)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM ingridients
            WHERE id = :id'
        );
        $stmt->bindValue(':id', $ingridient->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
}