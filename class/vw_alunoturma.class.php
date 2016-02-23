<?php

/*
 * Classe vw_alunoturma
 */

include_once 'bd/banco.class.php';

class vw_alunoturma {

    private $id;
    private $id_turma;
    private $ra;
    private $perletivo;

    public function __construct($id = '') {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];
        
        $this->perletivo = $perlet;
        $this->id = $id;        
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_alunoturma WHERE id = ?;";
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
        $query = "SELECT * FROM vw_alunoturma;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_alunoturma();
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
        $query = "UPDATE vw_alunoturma SET 
						ra = ?,
                                                id_turma = ?,
                                                perletivo = ?
						WHERE id ='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->ra, $this->id_turma,  $this->perletivo));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_alunoturma WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_alunoturma (ra,id_turma,perletivo) VALUES (?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->ra, $this->id_turma,  $this->perletivo));
        $this->id = $link->lastInsertId();
        return $result;
    }
    function getPerletivo() {
        return $this->perletivo;
    }

    function setPerletivo($perletivo) {
        $this->perletivo = $perletivo;
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

    public function setRa($ra = '') {
        $this->ra = $ra;
        return true;
    }

    public function getRa() {
        return $this->ra;
    }

    public function selectAllbyId_turma() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT t.* FROM vw_alunoturma t JOIN vw_aluno a ON t.ra = a.ra WHERE t.id_turma = ?  ORDER BY a.nome;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_alunoturma();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function countById_turma() {
        $link = banco::pdoCon();
        $query = "SELECT COUNT(1) FROM vw_alunoturma t JOIN vw_aluno a ON t.ra = a.ra WHERE t.id_turma = ?;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_turma));

        if ($result) {
            return $stmt->fetchColumn(0);
        }
        return -1;
    }

}

?>