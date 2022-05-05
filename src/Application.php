<?php

namespace Base;

use App\Controller\User;
use App\Controller\Blog;

class Application
{

    private $route;

    /** @var AbstractController */
    private $controller;
    private $actionName;
    private $param;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        try {
            require_once 'Orm.php';
            $this->addRoutes();
            $this->initController();
            $this->initAction();
            $this->initParam();

            $view = new View();
            $this->controller->setView($view);
            $this->initUser();

            if ($this->param)
                $content = $this->controller->{$this->actionName}($this->param);
            else
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

    private function initUser()
    {
        $Session = Session::getInstance();

        if ($user_id = $Session->getUserId()) {
            $user = \App\Model\User::getById($user_id);
            if ($user) {
                $this->controller->setUser($user);
            }
        }
    }

    private function addRoutes()
    {
        ///** @uses \App\Controller\User::loginAction() */
        $this->route->addRoute('/user/go', User::class, 'login');
        ///** @uses \App\Controller\User::registerAction() */
        $this->route->addRoute('/admin/', \App\Controller\Admin::class, 'index');
        $this->route->addRoute('/blog', \App\Controller\Blog::class, 'index');
        $this->route->addRoute('/blog/', \App\Controller\Blog::class, 'index');
        //$this->route->addRoute('/blog/index', \App\Controller\Blog::class, 'index');
        $this->route->addRoute('/', Blog::class, 'index');
    }

    private function initController()
    {
        $controllerName = $this->route->getControllerName();
        if (!class_exists($controllerName)) {
            throw new RouteException('Cant find controller ' . $controllerName);
        }

        $this->controller = new $controllerName();
    }

    private function initAction()
    {
        $actionName = $this->route->getActionName();
        if (!method_exists($this->controller, $actionName)) {
            $this->actionName = "index";
//            throw new RouteException('Action ' . $actionName . ' not found in ' . get_class($this->controller));
        }

        $this->actionName = $actionName;
    }

    private function initParam()
    {
        $this->param = $this->route->getParam();
    }

}
