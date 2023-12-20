<?php
namespace Todo\Models;

/** Class Todo **/
class Todo {

    private $id;
    private $name;
    private $user_id;
    private $tasks = [];

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }

    public function setName(String $name) {
        $this->name = $name;
    }

    public function setUser_id(String $user_id) {
        $this->user_id = $user_id;
    }

    public function tasks()
    {
        $manager = new TaskManager();
        if (!$this->tasks) {
            $this->tasks = $manager->getAll($this->getId());
        }

        return $this->tasks;
}

}

?>