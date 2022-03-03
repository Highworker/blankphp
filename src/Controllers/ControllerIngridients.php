<?php
namespace Sergejandreev\Blankphp\Controllers;
use Sergejandreev\Blankphp\Core\Controller;
use Sergejandreev\Blankphp\Core\Database;
use Sergejandreev\Blankphp\Entities\Ingridient;
use Sergejandreev\Blankphp\Core\View;
use Sergejandreev\Blankphp\Repositories\IngridientRepository;

class ControllerIngridients extends Controller
{
    private $ingridientModel;
    private IngridientRepository $ingridientRepository;

    public function __construct()
    {
        $this->ingridientRepository = new IngridientRepository((new Database())->connection());
        $this->ingridientModel = new Ingridient();
        $this->view = new View();
    }

    public function action_list()
    {
        $data = $this->ingridientRepository->findAll();
        $this->view->pageGenerate('ingridients.php', $data);
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

    public function show()
    {
        $data = $this->ingridientModel->setId($id);
        $this->view->pageGenerate('cookbook/read.php', $data);
    }

    public function updateShow()
    {
        if(isset($_POST) || !empty($_POST) || $_POST['id']){
            $data = $this->ingridientRepository->findById($_POST['id']);
        }
        $this->view->pageGenerate('ingridient_update.php', $data);
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