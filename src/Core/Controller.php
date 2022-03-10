<?php
namespace Sergejandreev\Blankphp\Core;
//TODO 2: добавить Session в Controller

class Controller extends Session {

    protected View $view;
    protected ?Request $request = null;
    protected ?Session $session = null;

    function __construct()
    {
        $this->session = new Session();
        $this->request = new Request();
        $this->view = new View($this->session); //TODO: сессия теперь в Controller (не во View)
    }
}