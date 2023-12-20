<?php 
    namespace Todo\Models;

    use Todo\Models\Task;
    /** Class UserManager **/
    class TaskManager {
        private $bdd;

        public function __construct() {
            $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function getBdd(){
            return $this->bdd;
        }

        public function getAll($list_id) {
            $stmt = $this->bdd->prepare("SELECT * FROM task WHERE list_id = ?");
            $stmt->execute(array(
                $list_id
            ));
            $stmt->setFetchMode(\PDO::FETCH_CLASS,"Todo\Models\Task");

            return $stmt->fetchAll();
        }

        public function find($name, $listId)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $listId
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Todo\Models\Task");

        return $stmt->fetch();
    }

    public function update($slug) {
        $stmt = $this->bdd->prepare("UPDATE Task SET name = ? WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $_POST['nameTask'],
            $slug,
            $_POST["list_id"]
        ));
    }

    public function delete($slug) {

        $stmt = $this->bdd->prepare("DELETE FROM task WHERE id = ? AND list_id = ?");
        $stmt->execute(array(
            $_POST["task_id"],
            $_POST["list_id"]
        ));
    }

    public function store($p, $b) {
        $stmt = $this->bdd->prepare("INSERT INTO task(name, list_id, checkTask) VALUES (?, ?, ?)");
        $stmt->execute(array(
            $p,
            $b,
            "no"
        ));
    }
    }
?>