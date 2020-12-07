<?php 
	include ("DB.php"); 
	/**
	 * 
	 */

	public class DB
	{
		
		function __construct()
		{
			
		}

		public function select($query)
		{
			$select = [];
			$result = $conection->query($query);
			while ($data = $result->fetch_assoc()) {
				$select[] = $data;
			}
			return $data;
		}
	}
?>