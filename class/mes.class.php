<?php

/*
 * Classe mes
 */

include_once 'bd/banco.class.php';

class mes {

    private $id;
    private $mes;
    private $ativo;
    private $perletivo;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function selectByMes() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM mes WHERE mes = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->mes));

        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $this->$column_name = $value;
                }
            }
            return true;
        }
        return false;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM mes WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $this->$column_name = $value;
                }
            }
            return true;
        }
        return false;
    }

    public function selectAll() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM mes;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new mes();
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
        $query = "UPDATE mes SET 
						mes = ?,
						ativo = ?,
						perletivo = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->mes, $this->ativo, $this->perletivo));

        return $stmt->result();
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM mes WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO mes (mes,ativo,perletivo) VALUES (?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->mes, $this->ativo, $this->perletivo));
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

    public function setMes($mes = '') {
        $this->mes = $mes;
        return true;
    }

    public function getMes() {
        return $this->mes;
    }

    public function setAtivo($ativo = '') {
        $this->ativo = $ativo;
        return true;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setPerletivo($perletivo = '') {
        $this->perletivo = $perletivo;
        return true;
    }

    public function getPerletivo() {
        return $this->perletivo;
    }

}

?>