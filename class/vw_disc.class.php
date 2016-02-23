<?php 
 /*
*Classe vw_disc
*/

include_once 'bd/banco.class.php'; 

class vw_disc{

	private $coddisc;
	private $nome;
	private $complemento;

	public function __construct($coddisc='')
	{
		$this->coddisc = $coddisc;
	}

	public function select()
	{

		$link = banco::pdoCon();
		$query = "SELECT * FROM vw_disc WHERE coddisc = ?;";
		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->coddisc));

		if($result) {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
				foreach($row as $key => $value)
				{
					$column_name = str_replace('-','_',$key);
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
		$query = "SELECT * FROM vw_disc;";

		$stmt = $link->query($query);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
		$item = new vw_disc();
			foreach($row as $key => $value)
			{
				$column_name = str_replace('-','_',$key);
				$item->$column_name = $value;

			}
		$list[] = $item;
		}
		return $list;
	}

	public function update()
	{


		$link = banco::pdoCon();
		$query = "UPDATE vw_disc SET 
						nome = ?,
						complemento = ? 
						WHERE coddisc='$this->coddisc';";

		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->nome,$this->complemento));

		return $result;
	}

	public function delete()
	{

		$link = banco::pdoCon();
		$query = "DELETE FROM vw_disc WHERE coddisc = ?;";
		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->coddisc));

		return $result;
	}

	public function insert()
	{


		$link = banco::pdoCon();
		$query ="INSERT INTO vw_disc (coddisc,nome,complemento) VALUES (?,?,?);";
		$stmt = $link->prepare($query);
		$result = $stmt->execute(array($this->coddisc,$this->nome,$this->complemento));
		$this->id = $link->lastInsertId();
		return $result;
	}

	public function setCoddisc($coddisc='')
	{
		$this->coddisc = $coddisc;
		return true;
	}

	public function getCoddisc()
	{
		return $this->coddisc;
	}

	public function setNome($nome='')
	{
		$this->nome = $nome;
		return true;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setComplemento($complemento='')
	{
		$this->complemento = $complemento;
		return true;
	}

	public function getComplemento()
	{
		return $this->complemento;
	}

}
 ?>