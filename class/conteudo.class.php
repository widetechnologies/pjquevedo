<?php

/*
 * Classe conteudo
 */

include_once 'bd/banco.class.php';

class conteudo {

    private $id;
    private $conteudo;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM conteudo WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));
        $bool = false;

        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $this->$column_name = $value;
                    $bool = true;
                }
            }
        }
        return $bool;
    }

    public function selectAll() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM conteudo;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new conteudo();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function update() {


        $link = banco::pdoCon();
        $query = "UPDATE conteudo SET 
						conteudo = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->conteudo));

        return result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM conteudo WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));
        return $result;
    }

    public function insert() {
        $link = banco::pdoCon();

        $query = "INSERT INTO conteudo (conteudo) VALUES (?);";

        $stmt = $link->prepare($query);
        $stmt->execute(array($this->conteudo));

        $this->id = $link->lastInsertId();
        return $result;
    }

    public function setId($id = '') {
        $this->id = $id;
        return true;
    }

    public function getId() {
        return $this->id;
    }

    public function setConteudo($conteudo = '') {
        $this->conteudo = $conteudo;
        return true;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

}

?>