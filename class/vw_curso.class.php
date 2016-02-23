<?php

/*
 * Classe vw_curso
 */

include_once 'bd/banco.class.php';

class vw_curso {

    private $id;
    private $nome;
    private $complemento;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_curso WHERE id = ?;";
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

    public function selectByRa($ra) {
        
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];

        $link = banco::pdoCon();
        $query = "SELECT complemento AS nome FROM vw_curso c
                  JOIN vw_aluno_curso ac ON ac.codcurso = c.id 
                  WHERE ac.ra = ? AND ac.perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($ra, $perlet));

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
        $query = "SELECT * FROM vw_curso;";

        $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_curso();
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
        $query = "UPDATE vw_curso SET 
						nome = ?,
						complemento = ? 
						WHERE id='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->nome, $this->complemento));

        return $result;
    }

    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_curso WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_curso (nome,complemento) VALUES (?,?);";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->nome, $this->complemento));
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

    public function setNome($nome = '') {
        $this->nome = $nome;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setComplemento($complemento = '') {
        $this->complemento = $complemento;
        return true;
    }

    public function getComplemento() {
        return $this->complemento;
    }

}

?>