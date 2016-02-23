<?php

include_once 'bd/banco.class.php';

class pesquisa_aluno extends vw_aluno {

    public function __construct($id_turma = '') {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];
        $this->perletivo = $perlet;
    }

    private $curso;
    private $perletivo;
    
                function getCurso() {
        return $this->curso;
    }

    function setCurso($curso) {
        $this->curso = $curso;
    }
      
     public function selectAllPesquisa($pesquisa) {
        $link = banco::pdoCon();

        $base = parse_ini_file('config/conf.ini', true);
        $base = $base['perletivo'];

        $list = array();
        $query = "SELECT DISTINCT a.nome, a.ra, vc.nome as curso
                  FROM vw_aluno a 
                  JOIN vw_aluno_curso c ON a.ra = c.ra 
                  JOIN vw_curso vc on vc.id=c.codcurso
                  WHERE a.nome like ? AND c.perletivo = ? 
                  ORDER BY a.nome;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($pesquisa, $base['perlet']));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new pesquisa_aluno();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }
    
    public function selectRA($ra) {

        $link = banco::pdoCon();
        $query = "SELECT DISTINCT a.nome, a.ra, vc.nome as curso
FROM vw_aluno a 
JOIN vw_aluno_curso c ON a.ra = c.ra 
JOIN vw_curso vc on vc.id=c.codcurso
WHERE a.ra = ? AND c.perletivo = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($ra, $this->perletivo));

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

}

?>