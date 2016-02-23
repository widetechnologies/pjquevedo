<?php

/*
 * Classe aula
 */

include_once 'bd/banco.class.php';

class aula {

    private $id;
    private $id_turma;
    private $id_conteudo;
    private $id_horario;
    private $id_mes;
    private $data;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function selectAllByMesRaId_turma($mes, $ra) {

        $link = banco::pdoCon();
        $query = "SELECT a.* FROM aula a JOIN presenca p ON p.id_aula = a.id WHERE a.id_turma = ? AND p.ra = ? AND Month(a.data) = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $ra, $mes));
        $bool = false;
        $list = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new aula();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllByTurmaMes($mes) {

        $link = banco::pdoCon();
        $query = "SELECT * FROM aula WHERE id_turma = ? AND MONTH(data) = ? ORDER BY data;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $mes));
        $bool = false;
        $list = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new aula();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllByTurmaData() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM aula WHERE id_turma = ? AND data = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->data));
        $bool = false;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new aula();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectByTurmaHorarioData() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM aula WHERE id_turma = ? AND id_horario = ? AND data = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->id_horario, $this->data));
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

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM aula WHERE id = ?;";
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

    public function selectAllByTurmaAndData() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM aula WHERE id_turma = ? AND data = ?;";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma, $this->data));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new aula();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAll() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM aula;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new aula();
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
        $query = "UPDATE aula SET 
						id_turma = ?,
                                                id_horario = ?,
						id_conteudo = ?,						
						id_mes = ?,
						data = ? 
						WHERE id = ?;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_turma, $this->id_horario, $this->id_conteudo, $this->id_mes, $this->data, $this->id));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM aula WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {

        $link = banco::pdoCon();
        $query = "INSERT INTO aula (id_turma,id_conteudo,id_horario,id_mes,data) VALUES (?,?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma, $this->id_conteudo, $this->id_horario, $this->id_mes, $this->data));
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

    public function setId_turma($id_turma = '') {
        $this->id_turma = $id_turma;
        return true;
    }

    public function getId_turma() {
        return $this->id_turma;
    }

    public function setId_conteudo($id_conteudo = '') {
        $this->id_conteudo = $id_conteudo;
        return true;
    }

    public function getId_conteudo() {
        return $this->id_conteudo;
    }

    public function setId_horario($id_horario = '') {
        $this->id_horario = $id_horario;
        return true;
    }

    public function getId_horario() {
        return $this->id_horario;
    }

    public function setId_mes($id_mes = '') {
        $this->id_mes = $id_mes;
        return true;
    }

    public function getId_mes() {
        return $this->id_mes;
    }

    public function setData($data = '') {
        $this->data = $data;
        return true;
    }

    public function getData() {
        return $this->data;
    }

}

?>
