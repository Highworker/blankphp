<?php
namespace Sergejandreev\Blankphp\Controllers;
use Sergejandreev\Blankphp\Core\Controller;
use Sergejandreev\Blankphp\Core\Database;
use Sergejandreev\Blankphp\Entities\Recipe;
use Sergejandreev\Blankphp\Repositories\RecipeRepository;
use Sergejandreev\Blankphp\Repositories\IngridientRepository;

class ControllerRecipes extends Controller
{
    public Recipe $recipeModel;
    private RecipeRepository $recipeRepository;
    private IngridientRepository $ingridientRepository;
    private Controller $baseController;

    public function __construct()
    {
        $this->recipeRepository = new RecipeRepository((new Database())->connection());
        $this->recipeModel = new Recipe();
        $this->baseController = new Controller();
        $this->session = $this->baseController->view->getSession();
    }

    public function show()
    {
        $this->baseController->view->pageGenerate('recipes.php', $this->recipeRepository->findAll(), $this->session->getSessionAsArray());
    }

    public function create()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['name'] || $_POST['description'] || $_POST['making']){
            $m = $this->recipeModel;
            $m->setName($_POST['name']);
            $m->setDescription($_POST['description']);
            $m->setMaking($_POST['making']);
            $this->recipeRepository->create($m);
        }
        header('Location: /recipes/manage');
    }

    public function updateShow()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['recipeid']){
            $this->baseController->view->pageGenerate('recipe_update.php', $this->recipeRepository->findById($_POST['recipeid']), $this->session->getSessionAsArray());
        }
    }

    public function updateAction()
    {
        $name = $_POST['name'] ?? null; //TODO: применить (может быть)
        if(isset($_POST) || !empty($_POST) || $_POST['id'] || $_POST['name'] || $_POST['description'] || $_POST['making']){
            $m = $this->recipeModel;
            $m->setId($_POST['id']);
            $m->setName($_POST['name']);
            $m->setDescription($_POST['description']);
            $m->setMaking($_POST['making']);
            $this->recipeRepository->update($m);
        }
        header('Location: /recipes/manage');
    }

    public function managebleList()
    {
        if ($this->session->getSessionAsArray() != null){
            $this->ingridientRepository = new IngridientRepository((new Database())->connection());
            $recipesData = $this->recipeRepository->findAll();
            // TODO: запилить в репозитории выборку НЕ входящих в рецепт ингридиентов (array_diff?), свойство avalible?
            $ingridientsData = $this->ingridientRepository->findAll();
        } else {
            $recipesData = null;
            $ingridientsData = null;
        }
        $this->baseController->view->pageGenerateWithManage('recipes_manageble.php','ingridients_manageble.php', $recipesData, $ingridientsData, $this->session->getSessionAsArray());
    }

    public function addIngridientToRecipe()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['ingridientid'] || $_POST['recipeid']){
            $this->recipeRepository->attachRecipeWithIngridients(intval($_POST['recipeid']), intval($_POST['ingridientid']));
        };
        header('Location: /recipes/manage');
    }

    public function removeIngridientFromRecipe()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['ingridientid'] || $_POST['recipeid']){
            $this->recipeRepository->detachRecipeWithIngridients(intval($_POST['recipeid']), intval($_POST['ingridientid']));
        };
        header('Location: /recipes/manage');
    }

    public function addCommentAction()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['recipeid'] || $_POST['userid']){
            if ($this->recipeRepository->checkPossibilityToAddComment($_POST['recipeid'], $_POST['userid'])){
                if($_POST['comment_text'] != ''){
                    $this->recipeRepository->addCommentToRecipe($_POST['recipeid'], $_POST['userid'], $_POST['comment_text']);
                    header('Location: /recipes');
                } else {
                    echo '<p>Введите текст комментария</p><a href="/recipes">Назад</a>';
                }
            } else {
                echo '<p>Вы уже комментировали этот рецепт</p><a href="/recipes">Назад</a>';
            }
        }
    }

    public function delete()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['id']){
            $m = $this->recipeModel;
            $m->setId($_POST['id']);
            $this->recipeRepository->delete($m);
        }
        header('Location: /recipes/manage');
    }
}