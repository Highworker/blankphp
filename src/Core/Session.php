<?php
namespace Sergejandreev\Blankphp\Core;

//TODO 1: запилить методы работы с сессией
class Session
{
    public ?array $userData;

    function __construct()
    {
        session_start();
        ob_start();

        if (isset($_SESSION['userlogin'])) {
            $this->userData['userlogin'] = mb_strtolower($_SESSION['userlogin']);
            $this->userData['userid'] = $_SESSION['userid'];
        } else {
            $this->userData['userlogin'] = null;
            $this->userData['userid'] = null;
        }
    }

    public function getSession() :Session
    {
        return $this;
    }
}