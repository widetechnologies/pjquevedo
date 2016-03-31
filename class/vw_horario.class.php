<?php

/*
 * Classe vw_horario
 */

include_once 'bd/banco.class.php';

class vw_horario {

    private $id_horario;
    private $hora_ini;
    private $hora_fim;
    private $dia_semana;
    private $turno;

    public function __construct($id_horario = '') {
        $this->id_horario = $id_horario;
    }

    public function selectAllSemanaById_turma($id_turma) {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT DISTINCT h.dia_semana "
                . "FROM vw_horaturma t, vw_horario h "
                . "WHERE t.id_turma = $id_turma AND t.id_horario = h.id_horario;";

        $stmt = $link->prepare($query);
        if ($stmt->execute(array($id_turma))) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $item = new vw_horario();
                foreach ($row as $key => $value) {
                    $column_name = str_replace('-', '_', $key);
                    $item->$column_name = $value;
                }
                $list[] = $item;
            }
        }
        return $list;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_horario WHERE id_horario = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_horario));

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
        $query = "SELECT * FROM vw_horario ORDER BY dia_semana,hora_ini;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_horario();
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
        $query = "UPDATE vw_horario SET 
						hora_ini = ?,
						hora_fim = ?,
						dia_semana = ?,
						turno = ? 
						WHERE id_horario='$this->id_horario';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->hora_ini, $this->hora_fim, $this->dia_semana, $this->turno));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_horario WHERE id_horario = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_horario));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_horario (hora_ini,hora_fim,dia_semana,turno) VALUES (?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->hora_ini, $this->hora_fim, $this->dia_semana, $this->turno));
        $this->id = $link->lastInsertId();
        return $result;
    }

    public function setId_horario($id_horario = '') {
        $this->id_horario = $id_horario;
        return true;
    }

    public function getId_horario() {
        return $this->id_horario;
    }

    public function setHora_ini($hora_ini = '') {
        $this->hora_ini = $hora_ini;
        return true;
    }

    public function getHora_ini() {
        return $this->hora_ini;
    }

    public function setHora_fim($hora_fim = '') {
        $this->hora_fim = $hora_fim;
        return true;
    }

    public function getHora_fim() {
        return $this->hora_fim;
    }

    public function setDia_semana($dia_semana = '') {
        $this->dia_semana = $dia_semana;
        return true;
    }

    public function getDia_semana() {
        return $this->dia_semana;
    }

    public function setTurno($turno = '') {
        $this->turno = $turno;
        return true;
    }

    public function getTurno() {
        return $this->turno;
    }

}

?>