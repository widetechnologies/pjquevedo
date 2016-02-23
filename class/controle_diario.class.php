<?php

/*
 * Classe controle_diario
 */

include_once 'bd/banco.class.php';

class controle_diario {

    private $id_controle_diario;
    private $id_turma;
    private $dt_modif;
    private $mes;
    private $perletivo;
    private $entregue;
    private $cod_func;

    public function __construct($id_controle_diario = '') {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];
        $this->perletivo = $perlet;

        $this->id_controle_diario = $id_controle_diario;
    }

    public function selectInserido() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM controle_diario WHERE id_turma = ? AND mes = ? AND perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->mes, $this->perletivo));

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
        $query = "SELECT * FROM controle_diario WHERE id_controle_diario = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_controle_diario));

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

    public function selectAllByCodProf($codprof) {
        $link = banco::pdoCon();
        $list = array();
        $query = "	
SELECT c.* FROM controle_diario c JOIN vw_turma t ON c.id_turma = t.id_turma WHERE c.perletivo = '$this->perletivo' AND t.cod_prof = ?;";
        $stmt = $link->prepare($query);
        $stmt->execute(array($codprof));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new controle_diario();
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
        $query = "UPDATE controle_diario SET 
						id_turma = ?,
						dt_modif = ?,
						mes = ?,
						perletivo = ?,
						entregue = ?,
						cod_func = ? 
						WHERE id_controle_diario='$this->id_controle_diario';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->dt_modif, $this->mes, $this->perletivo, $this->entregue, $this->cod_func));

        return $stmt->result();
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM controle_diario WHERE id_controle_diario = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_controle_diario));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO controle_diario (id_turma,dt_modif,mes,perletivo,entregue,cod_func) VALUES (?, GETDATE(),?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma, $this->mes, $this->perletivo, $this->entregue, $this->cod_func));

        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id_controle_diario = $id['id_controle_diario'];
        return $result;
    }

    public function setId_controle_diario($id_controle_diario = '') {
        $this->id_controle_diario = $id_controle_diario;
        return true;
    }

    public function getId_controle_diario() {
        return $this->id_controle_diario;
    }

    public function setId_turma($id_turma = '') {
        $this->id_turma = $id_turma;
        return true;
    }

    public function getId_turma() {
        return $this->id_turma;
    }

    public function setDt_modif($dt_modif = '') {
        $this->dt_modif = $dt_modif;
        return true;
    }

    public function getDt_modif() {
        return $this->dt_modif;
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

    public function setEntregue($entregue = '') {
        $this->entregue = $entregue;
        return true;
    }

    public function getEntregue() {
        return $this->entregue;
    }

    public function setCod_func($cod_func = '') {
        $this->cod_func = $cod_func;
        return true;
    }

    public function getCod_func() {
        return $this->cod_func;
    }

}

?>