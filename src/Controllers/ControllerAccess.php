<?php
namespace Sergejandreev\Blankphp\Controllers;
use Sergejandreev\Blankphp\Core\Controller;
use Sergejandreev\Blankphp\Core\Database;
use Sergejandreev\Blankphp\Core\Request;
use Sergejandreev\Blankphp\Repositories\UserRepository;

class ControllerAccess extends Controller
{
    private UserRepository $userRepository;
    private Controller $baseController;

    /**
     * ControllerAccess constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository((new Database())->connection());
        $this->baseController = new Controller();
        $this->session = $this->baseController->getSession();
        $this->request = $this->baseController->request;
    }

    public function action_list()
    {
        header('Location: /recipes');
    }

    public function registrationShow()
    {
        $data[] = 'Укажите логин и пароль';
        $this->baseController->view->pageGenerate('/registration.php', $data, $this->session->userData);

    }

    public function registrationAction()
    {
        $r = $this->request->getRequestEntries();
        // TODO: тернарные условия
        if ($r) {
            $login = strtolower($r['login']);
            if ($r['login'] || $r['password']) {
                if ($this->userRepository->userLoginExist($login) == true) {
                    $data[] = 'Логин занят';
                }
                if ($this->userRepository->userLoginExist($login) == false) {
                    $this->userRepository->userAdd($login, $r['password']);
                    $data[] = 'Пользователь зарегистрирован';
                }
            }
        } else {
            $data[] = 'Форма не отправлена';
        }
        $this->baseController->view->pageGenerate('/registration.php', $data, $this->session->userData);
    }

    public function loginShow()
    {
        $data[] = 'Введите логин и пароль, которые были указаны при регистрации';
        $this->baseController->view->pageGenerate('/login.php', $data, $this->session->userData);
    }

    public function loginAction()
    {
        /*
        // TODO: тернарные условия
        if ($arr['index'] ?? false) {
            ...
        }
        */
        $r = $this->request->getRequestEntries();
        if ($r) {
            $login = strtolower($r['login']);
            if ($this->userRepository->userLoginExist($login) == true) {
                if ($this->userRepository->userLoginPasswordComparsion($login, $_POST['password']) == true){
                    $_SESSION['userlogin'] = $login;
                    $_SESSION['userid'] = $this->userRepository->getUserIdByLogin($login);
                    $data[] = 'Вы залогинены';
                    header('Location: /');
                } else {
                    $data[] = 'Неправильный пароль';
                }
            } else {
                if ($this->userRepository->userLoginExist($login) == false) {
                    $data[] = 'Такого логина нет, или пароль не подходит';
                }
            }
        }
        $this->view->pageGenerate('/login.php', $data);
    }

    public function logoutAction(){
        session_unset();
        session_destroy();
        header('Location: /');
    }
}