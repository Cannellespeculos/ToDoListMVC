<?php
    namespace Todo\Models;

    class Task {

        private $id ;
        private $name;
        private $list_id;
        private $checkTask;

        public function getId() {
            return $this->id;
        }
    
        public function getName() {
            return $this->name;
        }
    
        public function getList_id() {
            return $this->list_id;
        }

        public function getCheckTask() {
            return $this->checkTask;
        }
    
        public function setId(Int $id) {
            $this->id = $id;
        }
    
        public function setName(String $name) {
            $this->name = $name;
        }
    
        public function setList_id(String $list_id) {
            $this->list_id = $list_id;
        }

        public function setCheckTask(String $checkTask) {
            return $this->checkTask = $checkTask;
        }

    }
?>