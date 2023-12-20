<?php 
namespace Todo\Controllers;

use Todo\Models\TaskManager;
use Todo\Validator;

class TaskController {
    private $manager;
    private $validator;

    public function __construct() {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }


    public function store() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTask"=>["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTask"], $_POST['list_id']);

            if (empty($res)) {
                $this->manager->store($_POST["nameTask"], $_POST['list_id']);
                header("Location: /dashboard/" . $_POST["nameList"]);
            }
        } else {
            header("Location: /dashboard/task/");
        }
        var_dump($_POST);
    }

    // public function delete($slug, $list)
    // {
    //     if (!isset($_SESSION["user"]["username"])) {
    //         header("Location: /login");
    //         die();
    //     }
    //     $this->manager->delete($slug);
    //     header("Location: /dashboard/".$list);
    // }

}
?>