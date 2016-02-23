<?php

include_once 'bd/banco.class.php';

class vw_turma {

    private $id_turma;
    private $perletivo;
    private $disciplina;
    private $turma;
    private $cod_prof;
    private $horarios;

    public function __construct($id_turma = '') {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];

        $this->id_turma = $id_turma;
        $this->perletivo = $perlet;
        $this->horarios = array();
    }

    public function addHorario($horario) {
        $this->horarios[] = $horario;
    }

    public function addAllHorario($horario) {
        $this->horarios = $horario;
    }

    public function selectAllByCod_profUnico() {
        $link = banco::pdoCon();

        $query = "SELECT * FROM vw_turma WHERE perletivo = ? AND id_turma = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->perletivo, $this->id_turma));
        $list = Array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_turma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllByMesAndCodprof($mes) {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT a.id_turma FROM aula a JOIN vw_turma t ON t.id_turma = a.id_turma  WHERE month(a.data) = ? AND t.cod_prof = ? AND t.perletivo = ? GROUP BY a.id_turma;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($mes, $this->cod_prof, $this->perletivo));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_turma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllByCod_prof() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM vw_turma WHERE cod_prof = ? AND perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->cod_prof, $this->perletivo));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_turma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function select() {

        $link = banco::pdoCon();

        $query = "SELECT * FROM vw_turma WHERE id_turma = ? AND perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->perletivo));

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

    public function selectByCodTurma() {

        $link = banco::pdoCon();

        $query = "SELECT * FROM vw_turma WHERE turma = ? AND perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->turma, $this->perletivo));

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

        $base = parse_ini_file('config/conf.ini', true);
        $base = $base['perletivo'];

        $list = array();
        $query = "SELECT * FROM vw_turma WHERE perletivo = ?;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($base['perlet']));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_turma();
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
        $query = "UPDATE vw_turma SET 
						perletivo = ?,
						disciplina = ?,
						turma = ?,
						cod_prof = ? 
						WHERE id_turma='$this->id_turma';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->perletivo, $this->disciplina, $this->turma, $this->cod_prof));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_turma WHERE id_turma = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_turma (perletivo,disciplina,turma,cod_prof) VALUES (?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->perletivo, $this->disciplina, $this->turma, $this->cod_prof));
        $this->id = $link->lastInsertId();
        return $result;
    }

    public function setId_turma($id_turma = '') {
        $this->id_turma = $id_turma;
        return true;
    }

    public function getId_turma() {
        return $this->id_turma;
    }

    public function setPerletivo($perletivo = '') {
        $this->perletivo = $perletivo;
        return true;
    }

    public function getPerletivo() {
        return $this->perletivo;
    }

    public function setDisciplina($disciplina = '') {
        $this->disciplina = $disciplina;
        return true;
    }

    public function getDisciplina() {
        return $this->disciplina;
    }

    public function setTurma($turma = '') {
        $this->turma = $turma;
        return true;
    }

    public function getTurma() {
        return $this->turma;
    }

    public function setCod_prof($cod_prof = '') {
        $this->cod_prof = $cod_prof;
        return true;
    }

    public function getCod_prof() {
        return $this->cod_prof;
    }

    function getHorarios() {
        return $this->horarios;
    }

    function setHorarios($horarios) {
        $this->horarios = $horarios;
    }

    public function selectByTurma() {

        $link = banco::pdoCon();

        $base = parse_ini_file('config/conf.ini', true);
        $base = $base['perletivo'];

        $query = "SELECT * FROM vw_turma WHERE turma = ? AND perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $base['perlet']));

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

    public function selectAllAlunosByCodprof($ra) {
        $link = banco::pdoCon();

        $base = parse_ini_file('config/conf.ini', true);
        $base = $base['perletivo'];

        $list = array();
        $query = "SELECT * FROM vw_turma t 
                  JOIN vw_alunoturma a on t.id_turma = a.id_turma
                  where a.ra = ? AND t.cod_prof=? AND t.perletivo = ?;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($ra, $this->cod_prof, $base['perlet']));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_turma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

}

?>
