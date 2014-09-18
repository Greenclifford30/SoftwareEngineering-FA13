<?php
echo "<div class = 'center'> ".validation_errors().""; 
$this->load->helper('html');
$this->load->helper('url');
echo "<h1>".$scname." enrollment year ".$grade."</h1>";
if ($items->num_rows() > 0){
echo "<table border=\"1\">";
echo "<tr><th>Student Identifier</th><th>Status</th></tr>";
foreach ($items->result() as $row)
{
	if($row->isenrolled == 't'){
		echo "<tr><td>AY".$grade.$row->identifier."</td><td>Enrolled</td></tr>";
	}
	else if($row->isaccept == 't'){
		echo "<tr><td>AY".$grade.$row->identifier."</td><td>Accepted</td></tr>";
	}
	else{
		echo "<tr><td>AY".$grade.$row->identifier."</td><td>Waiting</td></tr>";
	}
} 
echo "</table>";
}
else{
	echo "<br><h3>This list is currently empty </h3><br>";
}
echo "<br><br><br>";
$x = $items->row();
echo form_open('pages/delete_list');
echo form_hidden('scid', $scid);
echo form_hidden('grade', $grade);
echo form_submit('submit','Delete List', 'onclick = "return confirm(\'Deleting a List removes all applications associated with that list. \\n Are you Sure?\')"');
echo form_close('</div>');
?>