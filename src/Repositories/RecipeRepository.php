<?php
namespace Sergejandreev\Blankphp\Repositories;
use PDO;
use Sergejandreev\Blankphp\Entities\AbstractEntity;
use Sergejandreev\Blankphp\Entities\Recipe;

class RecipeRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        $stmtRecipes = $this->db->query('
            SELECT 
                   id, 
                   name, 
                   description, 
                   making 
            FROM recipes
            ORDER BY id
            ');
            while ($resultRecipesQuery = $stmtRecipes->fetch(PDO::FETCH_ASSOC)) {
                $recipe = new Recipe();
                $recipe
                    ->setId($resultRecipesQuery['id'])
                    ->setName($resultRecipesQuery['name'])
                    ->setDescription($resultRecipesQuery['description'])
                    ->setMaking($resultRecipesQuery['making'])
                ;
                $recipe->setIngridients($this->findAllInboxIngridients($recipe->getId()));
                $recipe->setComments($this->findAllComments($recipe->getId()));
                $recipes[] = $recipe;
            }
        return $recipes;
    }

    /**
     * @param $id
     * @return array
     */
    public function findAllInboxIngridients($id)
    {
        $stmtRecipeIngridients = $this->db->prepare('
            SELECT ingridients.name, ingridients.id
            FROM recipes
            LEFT JOIN recipes_ingridients ON recipes.id = recipes_ingridients.id_recipes
            LEFT JOIN ingridients ON ingridients.id = recipes_ingridients.id_ingridients
            WHERE recipes.id = :id
            ');
        $stmtRecipeIngridients->bindValue(':id',$id, PDO::PARAM_INT);
        $stmtRecipeIngridients->execute();
        return $stmtRecipeIngridients->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array
     */
    public function findAllComments($id)
    {
        $stmtRecipeComments = $this->db->prepare('
            SELECT 
                   comment, 
                   id_comments
            FROM comments
            LEFT JOIN recipes ON id_recipes = recipes.id
            WHERE recipes.id = :id       
        ');
        $stmtRecipeComments->bindValue(':id',$id, PDO::PARAM_INT);
        $stmtRecipeComments->execute();
        return $stmtRecipeComments->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkPossibilityToAddComment(int $recipe_id, int $user_id){
        $stmtRecipeComment = $this->db->prepare('
            SELECT 
                   id_recipes, 
                   id_users 
            FROM comments
            WHERE id_recipes = :recid
            AND id_users = :userid
        ');
        $stmtRecipeComment->bindValue(':recid', $recipe_id, PDO::PARAM_STR);
        $stmtRecipeComment->bindValue(':userid', $user_id, PDO::PARAM_STR);
        $stmtRecipeComment->execute();
        $responce = $stmtRecipeComment->fetch(PDO::FETCH_ASSOC);
        if (!$responce){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $recipe_id
     * @param int $user_id
     * @param string $comment
     */
    public function addCommentToRecipe(int $recipe_id, int $user_id, string $comment)
    {
        $stmtRecipeComment = $this->db->prepare('
            INSERT INTO comments (
                id_recipes,
                id_users,
                comment
            ) 
            VALUES( 
                :recid, 
                :userid,
                :comment
            )
        ');
        $stmtRecipeComment->bindValue(':recid',$recipe_id, PDO::PARAM_INT);
        $stmtRecipeComment->bindValue(':userid',$user_id, PDO::PARAM_INT);
        $stmtRecipeComment->bindValue(':comment',$comment, PDO::PARAM_STR);
        $stmtRecipeComment->execute();
    }

    /**
     * @param int|null $recipe_id
     * @param int|null $ingridient_id
     * @return bool
     */
    public function attachRecipeWithIngridients(?int $recipe_id, ?int $ingridient_id){
        $stmt = $this->db->prepare('
            INSERT INTO recipes_ingridients (
                id_ingridients,
                id_recipes
                ) 
            VALUES( 
                :ingid, 
                :recid
                )
            ');
        $stmt->bindValue(':ingid', $ingridient_id, PDO::PARAM_INT);
        $stmt->bindValue(':recid', $recipe_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @param int|null $recipe_id
     * @param int|null $ingridient_id
     * @return bool
     */
    public function detachRecipeWithIngridients(?int $recipe_id, ?int $ingridient_id){
        $stmt = $this->db->prepare(
            'DELETE FROM recipes_ingridients
            WHERE id_recipes = :recid
            AND id_ingridients = :ingid
            ');
        $stmt->bindValue(':ingid', $ingridient_id, PDO::PARAM_INT);
        $stmt->bindValue(':recid', $recipe_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @param $id
     * @return Recipe
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT
                id,
                name,
                description,
                making
            FROM recipes
            WHERE id = :id
            LIMIT 1
            ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $recipe = new Recipe();
        $recipe
            ->setId($result['id'])
            ->setName($result['name'])
            ->setDescription($result['description'])
            ->setMaking($result['making'])
        ;
        return $recipe;

    }

    /**
     * @param AbstractEntity $recipe
     * @return string
     */
    public function create(AbstractEntity $recipe)
    {
        $stmt = $this->db->prepare('
            INSERT INTO recipes (
                 name, 
                 description,
                 making
                 ) 
            VALUES (
                :name, 
                :description, 
                :making
                )
            ');
        $stmt->bindValue(':name', $recipe->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $recipe->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':making', $recipe->getMaking(), PDO::PARAM_STR);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $recipe->setId($id);
        return $id;
    }

    /**
     * @param AbstractEntity $recipe
     * @return bool
     */
    public function update(AbstractEntity $recipe)
    {
        $stmt = $this->db->prepare('
            UPDATE recipes 
            SET
                name = :name,
                description = :description,
                making = :making
            WHERE id = :id'
        );
        $stmt->bindValue(':id', $recipe->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $recipe->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $recipe->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':making', $recipe->getMaking(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param AbstractEntity $ingridient
     * @return bool
     */
    public function delete(AbstractEntity $ingridient)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM recipes
            WHERE id = :id'
        );
        $stmt->bindValue(':id', $ingridient->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
}