<?php
namespace Sergejandreev\Blankphp\Repositories;
use PDO;
use Sergejandreev\Blankphp\Entities\AbstractEntity;
use Sergejandreev\Blankphp\Entities\User;

class UserRepository {

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function userAdd(string $userLogin, string $userPassword){
        $stmt = $this->db->prepare(
            'INSERT INTO users (
                login,
                password
            ) VALUES ( 
                :login,
                :password
                )'
        );
        $stmt->bindValue(':login', $userLogin, PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($userPassword), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param string $userLogin
     * @return bool
     */
    public function userLoginExist(string $userLogin){
        $stmt = $this->db->prepare('
            SELECT login 
            FROM users
            WHERE login = :login');
        $stmt->bindValue(':login', $userLogin, PDO::PARAM_STR);
        $stmt->execute();
        $responce = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($responce){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $userLogin
     * @param string $userPassword
     * @return bool
     */
    public function userLoginPasswordComparsion(string $userLogin, string $userPassword){
        $stmt = $this->db->prepare('
            SELECT login, password 
            FROM users
            WHERE login = :login
            AND password = :password
            ');
        $stmt->bindValue(':login', $userLogin, PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($userPassword), PDO::PARAM_STR);
        $stmt->execute();
        $responce = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($responce){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $userLogin
     * @return mixed
     */
    public function getUserIdByLogin(string $userLogin)
    {
        $stmtUserId = $this->db->prepare('
            SELECT 
                   id_user 
            FROM 
                 users
            WHERE 
                  login = :login
            ');
        $stmtUserId->bindValue(':login', $userLogin, PDO::PARAM_STR);
        $stmtUserId->execute();
        $userId = $stmtUserId->fetch(PDO::FETCH_ASSOC);
        return $userId['id_user'];
    }
}