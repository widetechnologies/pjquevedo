<?php

/*
 * Classe vw_aluno_curso
 */

include_once 'bd/banco.class.php';

class vw_aluno_curso {

    private $id;
    private $ra;
    private $codcurso;
    private $periodo;
    private $perletivo;
    private $codturno;

    public function __construct() {
        $base = parse_ini_file('./config/conf.ini', true);
        $perletivo = $base['perletivo'];
        $perlet = $perletivo['perlet'];
        $this->perletivo = $perlet;
    }

    public function selectByIdTurma($idturma) {
        $list = array();
        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_aluno_curso WHERE"
                . " perletivo= ? AND ra IN("
                . " SELECT ra FROM vw_alunoturma"
                . " WHERE id_turma = ?);";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->perletivo, $idturma));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new vw_aluno_curso();
            foreach ($row as $key => $value) {
                $column_name = str_replace('-', '_', $key);
                $item->$column_name = $value;
            }
            $list[] = $item;
        }
        return $list;
    }

    public function insert() {


        $link = banco::pdoCon();
        $query = "INSERT INTO vw_aluno_curso (ra,codturno,codcurso,periodo,perletivo) VALUES (?,?,?,?,?);";
        $stmt = $link->prepare($query);
//        echo '<pre>';
//        print_r($this);
//        echo '</pre>'; die();
        $result = $stmt->execute(array($this->ra,  $this->codturno, $this->codcurso, $this->periodo,  $this->perletivo));
        $this->id = $link->lastInsertId();
        return $result;
    }
    
    public function delete() {

        $link = banco::pdoCon();
        $query = "DELETE FROM vw_aluno_curso WHERE id = ?;";
        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->id));

        return $result;
    }

    public function update() {


        $link = banco::pdoCon();
        $query = "UPDATE vw_aluno_curso SET 
						ra = ?,
						codcurso = ?,
						periodo = ?,
						perletivo = ?,
						codturno = ? 
						WHERE id ='$this->id';";

        $stmt = $link->prepare($query);

        $result = $stmt->execute(array($this->ra, $this->codcurso, $this->periodo, $this->perletivo, $this->codturno));

        return $result;
    }

    public function select() {

        $link = banco::pdoCon();
        $query = "SELECT * FROM vw_aluno_curso WHERE id = ?;";
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
    
    public function selectAll()
	{
		$link = banco::pdoCon();
		$list = array();
		$query = "SELECT * FROM vw_aluno_curso;";

		$stmt = $link->query($query);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
		$item = new vw_aluno_curso();
			foreach($row as $key => $value)
			{
				$column_name = str_replace('-','_',$key);
				$item->$column_name = $value;

			}
		$list[] = $item;
		}
		return $list;
	}


    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setRa($ra = '') {
        $this->ra = $ra;
        return true;
    }

    public function getRa() {
        return $this->ra;
    }

    public function setCodcurso($codcurso = '') {
        $this->codcurso = $codcurso;
        return true;
    }

    public function getCodcurso() {
        return $this->codcurso;
    }

    public function setPeriodo($periodo = '') {
        $this->periodo = $periodo;
        return true;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getPerletivo() {
        return $this->perletivo;
    }

    public function getCodturno() {
        return $this->codturno;
    }

    public function setPerletivo($perletivo) {
        $this->perletivo = $perletivo;
    }

    public function setCodturno($codturno) {
        $this->codturno = $codturno;
    }

    public function filtrarByRA($todosAlunosCursos, $ra) {
        foreach ($todosAlunosCursos as $alunoCurso) {
            if ($alunoCurso->getRa() == $ra) {
                return $alunoCurso;
            }
        }
        return null;
    }

}

?>