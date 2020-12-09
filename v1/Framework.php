<?php 
	include ("DB.php"); 

	class DB
	{
		public $conection;

		function __construct()
		{
			$Conexion = new Conexion();
			$this->conection = $Conexion->conection;
		}

		public function select($query)
		{
			$select = [];
			$result = $this->conection->query($query);
			while ($data = $result->fetch_assoc()) {
				$select[] = $data;
			}
			return $select;
		}

		public function findAllBy($tabla, $nombre_columna, $value)
		{
			$query = "select * from $tabla where $nombre_columna = '$value'";
			$select = [];
			$result = $this->conection->query($query);
			while ($data = $result->fetch_assoc()) {
				$select[] = $data;
			}
			return $select;
		}

		public function findBy($tabla, $nombre_columna, $value)
		{
			$query = "select * from $tabla where $nombre_columna = '$value' limit 1";
			$select = [];
			$result = $this->conection->query($query);
			while ($data = $result->fetch_assoc()) {
				$select[] = $data;
			}

			if(count($select) > 0) return (object) $select[0];

			return null;			
		}

		public function findAll($tabla)
		{
			$query = "select * from $tabla";
			$select = [];
			$result = $this->conection->query($query);
			while ($data = $result->fetch_assoc()) {
				$select[] = $data;
			}
			return $select;
		}

		public function execute($query)
		{
			$select = [];
			$result = $this->conection->query($query);
			return $result;
		}
	}
?>