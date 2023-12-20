<?php

namespace Todo\Controllers;

use Todo\Models\TodoManager;
use Todo\Validator;

/** Class UserController **/
class TodoController {
    private $manager;
    private $validator;

    public function __construct() {
        $this->manager = new TodoManager();
        $this->validator = new Validator();
    }

    public function index() {
        require VIEWS . 'Todo/homepage.php';
    }

    public function create() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Todo/create.php';
    }

    public function store() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "name"=>["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["name"], $_SESSION["user"]["id"]);

            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/" . $_POST["name"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/nouveau");
            }
        } else {
            header("Location: /dashboard/nouveau");
        }
    }

    public function update($slug) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTodo"=>["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTodo"], $_SESSION["user"]["id"]);

            if (empty($res) || $res->getName() == $slug) {
                $search = $this->manager->update($slug);
                header("Location: /dashboard/" . $_POST['nameTodo']);
            } else {
                $_SESSION["error"]['nameTodo'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/" . $slug);
            }

        } else {
            header("Location: /dashboard/" . $slug);
        }
    }

    public function delete($slug)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->manager->delete($slug);
        header("Location: /dashboard");
    }

    public function showAll() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $todos = $this->manager->getAll();

        require VIEWS . 'Todo/index.php';
    }

    public function show($slug) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $todo = $this->manager->find($slug, $_SESSION["user"]["id"]);
        if (!$todo) {
            header("Location: /error");
        }
        require VIEWS . 'Todo/show.php';
    }

}
