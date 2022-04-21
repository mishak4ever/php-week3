<?php

namespace Base;

use App\Controller\User;

class Application {

    private $route;

    /** @var AbstractController */
    private $controller;
    private $actionName;

    public function __construct() {
        $this->route = new Route();
    }

    public function run() {
        try {
            $this->addRoutes();
            $this->initController();
            $this->initAction();

            $view = new View();
            $this->controller->setView($view);
            $this->initUser();

            $content = $this->controller->{$this->actionName}();

            echo $content;
        } catch (RedirectException $e) {
            header('Location: ' . $e->getUrl());
            die;
        } catch (RouteException $e) {
            header("HTTP/1.0 404 Not Found");
            echo $e->getMessage();
        }
    }

    private function initUser() {
        $Session = Session::getInstance();

        if ($user_id = $Session->getUserId()) {
            $user = \App\Model\User::getById($user_id);
            if ($user) {
                $this->controller->setUser($user);
            }
        }
    }

    private function addRoutes() {
        ///** @uses \App\Controller\User::loginAction() */
        $this->route->addRoute('/user/go', User::class, 'login');
        ///** @uses \App\Controller\User::registerAction() */
        //$this->route->addRoute('/user/register', \App\Controller\User::class, 'register');
        ///** @uses \App\Controller\Blog::indexAction() */
        $this->route->addRoute('/blog', \App\Controller\Blog::class, 'index');
        $this->route->addRoute('/blog/', \App\Controller\Blog::class, 'index');
        //$this->route->addRoute('/blog/index', \App\Controller\Blog::class, 'index');
        $this->route->addRoute('/', User::class, 'login');
    }

    private function initController() {
        $controllerName = $this->route->getControllerName();
        if (!class_exists($controllerName)) {
            throw new RouteException('Cant find controller ' . $controllerName);
        }

        $this->controller = new $controllerName();
    }

    private function initAction() {
        $actionName = $this->route->getActionName();
        if (!method_exists($this->controller, $actionName)) {
            $this->actionName = "index";
//            throw new RouteException('Action ' . $actionName . ' not found in ' . get_class($this->controller));
        }

        $this->actionName = $actionName;
    }

}