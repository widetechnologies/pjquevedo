<?php

/*
 * Classe usuario
 */

include_once 'bd/banco.class.php';

class usuario {

    private $id;
    private $login;
    private $senha;
    //a variavel nome sera o usuario do rm se o login for diferente
    private $nome;
    private $tipo;
    private $ativo;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function setAtributos($array_attr) {
        foreach ($array_attr as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Método de autenticacao de usuarios
     * @return boolean Verdadeiro ou falso.
     */
    public function login() {
        $ds = ldap_connect("172.16.0.42");
        if ($ds) {

            $usr = "LABINFO\\" . $this->login;
            $r = @ldap_bind($ds, $usr, $this->senha);
            if ($r) {
                return true;
            }
        }
        return false;
    }

    public function selectByLoginSenha() {
        $bool = false;
        $link = banco::pdoCon();
        $query = "SELECT * FROM escola.usuario WHERE login = ? AND senha = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->login,  $this->senha));
        //var_dump($stmt->errorInfo()); die();
        if ($result > 0) {
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
        $query = "SELECT * FROM usuario WHERE id = ?;";
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
        $query = "SELECT * FROM usuario;";

        $stmt = $link->prepare($query);
        $stmt->execute();
        //var_dump($stmt->errorInfo()); die();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new usuario();
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
        $query = "UPDATE usuario SET 
                login = ?,
                nome = ?,
                tipo = ?,
                ativo = ? 
                WHERE id = ?;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->login, $this->nome, $this->tipo, $this->ativo, $this->id));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM usuario WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {
        $link = banco::pdoCon();
        $query = "INSERT INTO usuario (login,nome,tipo,ativo) VALUES (?,?,?,?);";
        $this->ativo = 1;
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->login, $this->nome, $this->tipo, $this->ativo));
        
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

    public function setLogin($login = '') {
        $this->login = $login;
        return true;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setSenha($senha = '') {
        $this->senha = $senha;
        return true;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setNome($nome = '') {
        $this->nome = $nome;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setTipo($tipo = '') {
        $this->tipo = $tipo;
        return true;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getDescricaoTipo() {
        switch ($this->tipo) {
            case 0:
                return 'Secretaria';
            case 1:
                return 'Administrador';
            case 2:
                return 'Professor';
            case 3:
                return 'Aluno';
        }
    }

    public function setAtivo($ativo = '') {
        $this->ativo = $ativo;
        return true;
    }

    public function getAtivo() {
        return $this->ativo;
    }

}

?>