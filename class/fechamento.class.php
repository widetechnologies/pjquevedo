<?php

/*
 * Classe fechamento
 */

include_once 'bd/banco.class.php';

class fechamento {

    private $id;
    private $id_turma;
    private $mes;
    private $perletivo;
    private $situacao;

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function selectById_turmaMes() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM fechamento WHERE id_turma = ? AND mes = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma,  $this->mes));
        $bool = false;
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $this->$column_name = $value;
                }
                $bool = true;
            }
        }
        return $bool;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM fechamento WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));
        $bool = false;
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $this->$column_name = $value;
                }
                $bool = true;
            }
        }
        return $bool;
    }

    public function selectAll() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM fechamento;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new fechamento();
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
        $query = "UPDATE fechamento SET 
                                                id_turma = ?,    
						mes = ?,
						perletivo = ?,
						situacao = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma,$this->mes, $this->perletivo, $this->situacao));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM fechamento WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO fechamento (id_turma,mes,perletivo,situacao) OUTPUT inserted.id VALUES (?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma,$this->mes, $this->perletivo, $this->situacao));
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $id['id'];
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

    public function setPerletivo($perletivo = '') {
        $this->perletivo = $perletivo;
        return true;
    }

    public function getPerletivo() {
        return $this->perletivo;
    }

    public function setSituacao($situacao = '') {
        $this->situacao = $situacao;
        return true;
    }

    public function getSituacao() {
        return $this->situacao;
    }
    function getId_turma() {
        return $this->id_turma;
    }

    function setId_turma($id_turma) {
        $this->id_turma = $id_turma;
    }



}

?>