<?php
namespace Sergejandreev\Blankphp\Core;

//TODO 1: запилить методы работы с сессией
class Session
{
    public ?array $userData = null;

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

    public function getSessionAsArray() :array|null
    {
        return $this->userData;
    }

    public function getUserLogin() :string|null
    {
        if ($this->userData != null){
            return $this->userData['userlogin'];
        } else {
            return null;
        }
    }
}