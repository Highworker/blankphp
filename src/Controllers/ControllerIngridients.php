<?php
namespace Sergejandreev\Blankphp\Controllers;
use Sergejandreev\Blankphp\Core\Controller;
use Sergejandreev\Blankphp\Core\Database;
use Sergejandreev\Blankphp\Entities\Ingridient;
use Sergejandreev\Blankphp\Repositories\IngridientRepository;

class ControllerIngridients extends Controller
{
    private $ingridientModel;
    private IngridientRepository $ingridientRepository;
    private Controller $baseController;


    public function __construct()
    {
        $this->ingridientRepository = new IngridientRepository((new Database())->connection());
        $this->ingridientModel = new Ingridient();
        $this->baseController = new Controller();
        $this->session = $this->baseController->view->getSession();
    }

    public function action_list()
    {
        $this->baseController->view->pageGenerate('ingridients.php', $this->ingridientRepository->findAll(), $this->session->getSessionAsArray());
    }

    public function create()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['name'] || $_POST['description']){
            $m = $this->ingridientModel;
            $m->setName($_POST['name']);
            $m->setDescription($_POST['description']);
            $this->ingridientRepository->create($m);
        }
        header('Location: /recipes/manage');
    }

    public function updateShow()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['id']){
            $this->baseController->view->pageGenerate('ingridient_update.php', $this->ingridientRepository->findById($_POST['id']), $this->session->getSessionAsArray());
        }
    }

    public function updateAction()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['id'] || $_POST['name'] || $_POST['description']){
            $m = $this->ingridientModel;
            $m->setId($_POST['id']);
            $m->setName($_POST['name']);
            $m->setDescription($_POST['description']);
            $this->ingridientRepository->update($m);
        }
        header('Location: /recipes/manage');
    }

    public function delete()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['id']){
            $m = $this->ingridientModel;
            $m->setId($_POST['id']);
            $this->ingridientRepository->delete($m);
        }
        header('Location: /recipes/manage');
    }
}