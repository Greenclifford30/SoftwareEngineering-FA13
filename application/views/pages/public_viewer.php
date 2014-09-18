<?php
	echo "<div class = 'center'> ".validation_errors()." </div>"; 
	$this->load->helper('html');
	$this->load->helper('url');
	echo "<h1>".$scname." enrollment year ".$grade."</h1>";
	if ($items->num_rows() > 0){
		echo "<table border=\"1\">";
		$counter = 1;
		foreach ($items->result() as $row)
		{
			echo "<tr><td>".$counter."</td><td>AY".$grade.$row->identifier."</td></tr>";
			$counter++;
		}
		
		echo "</table>";
	}
	else{
		echo "<br><h3>This list is currently empty </h3><br>";
	}
?>
