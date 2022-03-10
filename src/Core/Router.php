<?php
namespace Sergejandreev\Blankphp\Core;
use Sergejandreev\Blankphp\Controllers\ControllerIngridients;
use Sergejandreev\Blankphp\Controllers\ControllerAccess;
use Sergejandreev\Blankphp\Controllers\ControllerRecipes;

class Router
{
    private static $routes = [
        '/' => [ControllerAccess::class, 'action_list'],
        '/login' => [ControllerAccess::class, 'loginShow'],
        '/logout' => [ControllerAccess::class, 'logoutAction'],
        '/login/action' => [ControllerAccess::class, 'loginAction'],
        '/registration' => [ControllerAccess::class, 'registrationShow'],
        '/registration/action' => [ControllerAccess::class, 'registrationAction'],
        '/recipes' => [ControllerRecipes::class, 'show'],
        '/recipes/manage' => [ControllerRecipes::class, 'managebleList'],
        '/recipes/create' => [ControllerRecipes::class, 'create'],
        '/recipes/delete' => [ControllerRecipes::class, 'delete'],
        '/recipes/update' => [ControllerRecipes::class, 'updateShow'],
        '/recipes/update/action' => [ControllerRecipes::class, 'updateAction'],
        '/recipes/manage/add_ingridient' => [ControllerRecipes::class, 'addIngridientToRecipe'],
        '/recipes/manage/delete_ingridient' => [ControllerRecipes::class, 'removeIngridientFromRecipe'],
        '/recipes/comment/add' => [ControllerRecipes::class, 'addCommentAction'],
        '/ingridients' => [ControllerIngridients::class, 'action_list'],
        '/ingridients/create' => [ControllerIngridients::class, 'create'],
        '/ingridients/update' => [ControllerIngridients::class, 'updateShow'],
        '/ingridients/update/action' => [ControllerIngridients::class, 'updateAction'],
        '/ingridients/delete' => [ControllerIngridients::class, 'delete']
    ];

    public static function start()
    {
        $route = self::$routes[$_SERVER['REQUEST_URI']] ?? null;
        [$controller, $action] = $route;
        if (!$controller || !class_exists($controller) || !method_exists($controller, $action)) {
            $var = new Router();
            $var->ErrorPage();
        }
        /** @var Controller $route */
        $controller = new $controller;
        $controller->$action();
    }

    public function ErrorPage()
    {
        include($_SERVER['DOCUMENT_ROOT'] . '/src/views/404.php');
        die();
    }
}