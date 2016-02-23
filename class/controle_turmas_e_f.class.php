<?php

/*
 * Classe vw_prof
 */

include_once 'bd/banco.class.php';

class controle_turmas_e_f {

    private $codprof;
    private $nome;
    private $faltantes;
    private $entregues;

    public function __construct($codprof = '') {
        $this->codprof = $codprof;
    }

    public function selectAllByMes($mes) {
        $link = banco::pdoCon();
        $list = array();

        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];

        $query = "
    SELECT 
	p.codprof, p.nome, (COUNT(t.id_turma) - COUNT(e.id_turma)) AS faltantes, COUNT(e.id_turma) AS entregues
    FROM	
	vw_prof p 
	JOIN vw_turma t  ON p.codprof = t.cod_prof  
	LEFT JOIN controle_diario e ON t.id_turma = e.id_turma 
	AND t.perletivo= e.perletivo AND e.mes = ?
    WHERE 
	 t.perletivo = '{$perlet}' 
	 GROUP BY p.codprof,p.nome
	 ORDER BY p.codprof;";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($mes));
        // $stmt = $link->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new controle_turmas_e_f();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    function getCodprof() {
        return $this->codprof;
    }

    function getNome() {
        return $this->nome;
    }

    function getFaltantes() {
        return $this->faltantes;
    }

    function getEntregues() {
        return $this->entregues;
    }

    function setCodprof($codprof) {
        $this->codprof = $codprof;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setFaltantes($faltantes) {
        $this->faltantes = $faltantes;
    }

    function setEntregues($entregues) {
        $this->entregues = $entregues;
    }

}

?>