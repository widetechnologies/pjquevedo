<?php

/*
 * Classe registro
 */

include_once 'bd/banco.class.php';

class registro {

    private $id;
    private $usuario;
    private $mes;
    private $id_turma;
    private $data_hora;
    private $tipo_op;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function selectById_turmaTipo_opMes() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM registro WHERE id_turma = ? AND tipo_op = ? AND mes = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->tipo_op,  $this->mes));
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
        $query = "SELECT * FROM registro WHERE id = ?;";
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
        $query = "SELECT * FROM registro;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new registro();
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
        $query = "UPDATE registro SET 
                                                usuario = ?,
                                                mes = ?,
                                                id_turma = ?,
						data_hora = ?,
						tipo_op = ?                                          
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->usuario, $this->mes, $this->id_turma, $this->data_hora, $this->tipo_op));

        return $stmt->result();
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM registro WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO registro (usuario,mes,id_turma,data_hora,tipo_op) OUTPUT inserted.id VALUES (?,?,?,GETDATE(),?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->usuario, $this->mes, $this->id_turma, $this->tipo_op));
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $id['id'];
        return $result;
    }

    public function setId($id = '') {
        $this->id = $id;
        return true;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getMes() {
        return $this->mes;
    }

    function getId_turma() {
        return $this->id_turma;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setId_turma($id_turma) {
        $this->id_turma = $id_turma;
    }

    public function getId() {
        return $this->id;
    }

    public function setData_hora($data_hora = '') {
        $this->data_hora = $data_hora;
        return true;
    }

    public function getData_hora() {
        return $this->data_hora;
    }

    public function setTipo_op($tipo_op = '') {
        $this->tipo_op = $tipo_op;
        return true;
    }

    public function getTipo_op() {
        return $this->tipo_op;
    }
    

}

?>