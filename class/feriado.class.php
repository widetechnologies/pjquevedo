<?php 
 /*
*Classe feriado
*/

include_once 'bd/banco.class.php'; 

class feriado{

	private $id_feriado;
	private $data;

	public function __construct($id_feriado='')
	{
		$this->id_feriado = $id_feriado;
	}

	public function select()
	{

		$link = banco::pdoCon();
		$query = "SELECT * FROM feriado WHERE id_feriado = ?;";
		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->id_feriado));

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
		$query = "SELECT id as id_feriado, data FROM feriado;";

		$stmt = $link->query($query);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
		$item = new feriado();
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
		$query = "UPDATE feriado SET 
						data = ? 
						WHERE id_feriado='$this->id_feriado';";

		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->data));

		return $stmt->result();
	}

	public function delete()
	{

		$link = banco::pdoCon();
		$query = "DELETE FROM feriado WHERE id = ?;";
		$stmt = $link->prepare($query);

		$result = $stmt->execute(array($this->id_feriado));

		return $result;
	}

	public function insert()
	{


		$link = banco::pdoCon();
		$query ="INSERT INTO feriado (data)  VALUES (?);";
		$stmt = $link->prepare($query);
		$result = $stmt->execute(array($this->data));
		$id = $stmt->fetch(PDO::FETCH_ASSOC);                         
                $this->id_feriado = $id['id_feriado'];                
		return $result;
	}

	public function setId_feriado($id_feriado='')
	{
		$this->id_feriado = $id_feriado;
		return true;
	}

	public function getId_feriado()
	{
		return $this->id_feriado;
	}

	public function setData($data='')
	{
		$this->data = $data;
		return true;
	}

	public function getData()
	{
		return $this->data;
	}

}
 ?>