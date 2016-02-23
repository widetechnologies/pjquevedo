<?php

/*
 * Classe vw_horaturma
 */

include_once 'bd/banco.class.php';

class vw_horaturma {

    private $id;
    private $id_turma;
    private $id_horario;
    private $sala;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function selectAllByDia_semana($dia_semana) {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];

        $link = banco::pdoCon();

        $query = "  select ht.* 
                    From	vw_turma t
                                join vw_horaturma ht On t.id_turma = ht.id_turma
                                Join vw_horario h On ht.id_horario = h.id_horario
                    Where	t.id_turma = ? AND 
                                h.dia_semana = ? AND
                                t.perletivo = ?;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $dia_semana, $perlet));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_horaturma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllById_turma() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM vw_horaturma WHERE id_turma = ?;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_horaturma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }
    
    public function selectById_turma() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_horaturma WHERE id_turma = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma));

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
        $query = "SELECT * FROM vw_horaturma WHERE id = ?;";
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
        $query = "SELECT * FROM vw_horaturma;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_horaturma();
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
        $query = "UPDATE vw_horaturma SET 
                                                id_turma = ?,
						id_horario = ?,
						sala = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->id_horario, $this->sala));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_horaturma WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_horaturma (id_turma,id_horario,sala) VALUES (?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma, $this->id_horario, $this->sala));
        $this->id = $link->lastInsertId();
        return $result;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setId_turma($id_turma = '') {
        $this->id_turma = $id_turma;
        return true;
    }

    public function getId_turma() {
        return $this->id_turma;
    }

    public function setId_horario($id_horario = '') {
        $this->id_horario = $id_horario;
        return true;
    }

    public function getId_horario() {
        return $this->id_horario;
    }

    public function setSala($sala = '') {
        $this->sala = $sala;
        return true;
    }

    public function getSala() {
        return $this->sala;
    }

}

?>