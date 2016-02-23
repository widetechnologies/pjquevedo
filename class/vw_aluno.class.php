<?php

/*
 * Classe vw_aluno
 */

include_once 'bd/banco.class.php';

class vw_aluno {

    private $ra;
    private $nome;
    private $cpf;
    private $telefone1;
    private $telefone2;
    private $empresa;
    private $turno;

    public function __construct($ra = '') {
        $this->ra = $ra;
    }

    public function selectAllPresentesByAula($id_aula) {
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT a.* FROM presenca p Join vw_aluno a ON p.ra = a.ra WHERE p.id_aula = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($id_aula));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_aluno();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function selectAllById_turma($id_turma) {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];
        $link = banco::pdoCon();
        $list = array();
        $query = "SELECT a.* FROM vw_alunoturma at Join vw_aluno a ON at.ra = a.ra WHERE at.id_turma = ? AND at.perletivo = ? ORDER BY a.nome;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($id_turma,$perlet));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_aluno();
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
        $query = "SELECT * FROM vw_aluno WHERE ra = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->ra));

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

    public function selectComTurno() {

        $link = banco::pdoCon();
        $query = "SELECT a.*, t.turno FROM vw_aluno a JOIN vw_aluno_curso c ON a.ra = c.ra JOIN vw_turno t ON t.codturno = c.codturno WHERE a.ra = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->ra));

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
        $query = "SELECT * FROM vw_aluno;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_aluno();
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
        $query = "UPDATE vw_aluno SET 
						nome = ?,
						cpf = ?,
						telefone1 = ?,
						telefone2 = ?,
						empresa = ?,
                                                turno = ?
						WHERE ra='$this->ra';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->nome, $this->cpf, $this->telefone1, $this->telefone2, $this->empresa,  $this->turno));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_aluno WHERE ra = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->ra));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_aluno (ra,nome,cpf,telefone1,telefone2,empresa,turno) VALUES (?,?,?,?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->ra, $this->nome, $this->cpf, $this->telefone1, $this->telefone2, $this->empresa,  $this->turno));
        $this->id = $link->lastInsertId();
        return $result;
    }

    function getTurno() {
        return $this->turno;
    }

    function setTurno($turno) {
        $this->turno = $turno;
    }

        public function setRa($ra = '') {
        $this->ra = $ra;
        return true;
    }

    public function getRa() {
        return $this->ra;
    }

    public function setNome($nome = '') {
        $this->nome = $nome;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setCpf($cpf = '') {
        $this->cpf = $cpf;
        return true;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setTelefone1($telefone1 = '') {
        $this->telefone1 = $telefone1;
        return true;
    }

    public function getTelefone1() {
        return $this->telefone1;
    }

    public function setTelefone2($telefone2 = '') {
        $this->telefone2 = $telefone2;
        return true;
    }

    public function getTelefone2() {
        return $this->telefone2;
    }

    public function setEmpresa($empresa = '') {
        $this->empresa = $empresa;
        return true;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

}

?>