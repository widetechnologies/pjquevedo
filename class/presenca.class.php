<?php

/*
 * Classe presenca
 */

include_once 'bd/banco.class.php';

class presenca {

    private $id;
    private $id_aula;
    private $ra;
    private $situacao;

    public function __construct($id = '') {
        $this->id = $id;
    }
    
     public function countAllPresentesByAulas($aulas) {
         if(empty($aulas)){
             return array();
         }
        $link = banco::pdoCon();
        $list = array();
        $query = "Select count(id) as count From presenca where id_aula IN ($aulas) group by id_aula;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as $key => $value) {
                //$column_name = str_replace('-', '_', $key);
                $list[] = $value;
            }
             
        }
        return $list;
    }
    
    public function countById_turmaRaMes($id_turma, $mes) {

        $link = banco::pdoCon();
        $query = "SELECT COUNT(p.ra) as cont FROM aula a JOIN presenca p ON a.id = p.id_aula WHERE MONTH(a.data) = ? AND p.ra = ? and a.id_turma = ? GROUP BY p.ra;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($mes, $this->ra, $id_turma));
         if ($result) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return intval($row['cont']);
        }
        return -1;
    }

    public function selectAllPresentesByAula() {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT * FROM presenca WHERE id_aula = ?;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_aula));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new presenca();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function countPresentesByAula() {

        $link = banco::pdoCon();
        $query = "Select count(id) as count From presenca where id_aula = ? group by id_aula;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_aula));

        if ($result) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return intval($row['count']);
        }
        return -1;
    }

    public function selectByAulaRa() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM presenca WHERE id_aula = ? AND ra = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_aula, $this->ra));
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
        $query = "SELECT * FROM presenca WHERE id = ?;";
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
        $query = "SELECT * FROM presenca;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new presenca();
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
        $query = "UPDATE presenca SET 
						id_aula = ?,
						ra = ?,
						situacao = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id_aula, $this->ra, $this->situacao));

        return $stmt->result();
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM presenca WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }
    
     public function deleteFromIdAula($id_aula) {

        $link = banco::pdoCon();
        $query = "DELETE FROM presenca WHERE id_aula = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($id_aula));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO presenca (id_aula,ra,situacao) VALUES (?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->id_aula, $this->ra, $this->situacao));
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

    public function setId_aula($id_aula = '') {
        $this->id_aula = $id_aula;
        return true;
    }

    public function getId_aula() {
        return $this->id_aula;
    }

    public function setRa($ra = '') {
        $this->ra = $ra;
        return true;
    }

    public function getRa() {
        return $this->ra;
    }

    public function setSituacao($situacao = '') {
        $this->situacao = $situacao;
        return true;
    }

    public function getSituacao() {
        return $this->situacao;
    }

}

?>