<?php

/*
 * Classe vw_prof
 */

include_once 'bd/banco.class.php';

class vw_prof {

    private $id;
    private $codprof;
    private $nome;
    private $email;
    private $usuario;

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function selectByCodprof() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_prof WHERE codprof = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->codprof));

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
        $query = "SELECT * FROM vw_prof WHERE id = ?;";
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
        $query = "SELECT * FROM vw_prof ORDER BY nome;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_prof();
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
        $query = "UPDATE vw_prof SET 
                                                codprof = ?,
						nome = ?,
						email = ?,
                                                usuario = ?
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->codprof, $this->nome, $this->email, $this->usuario));
        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_prof WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_prof (codprof,nome,email,usuario) VALUES (?,?,?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->codprof, $this->nome, $this->email, $this->usuario));
        $this->id = $link->lastInsertId();
        return $result;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setCodprof($codprof = '') {
        $this->codprof = $codprof;
        return true;
    }

    public function getCodprof() {
        return $this->codprof;
    }

    public function setNome($nome = '') {
        $this->nome = $nome;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setEmail($email = '') {
        $this->email = $email;
        return true;
    }

    public function getEmail() {
        return $this->email;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

}

?>