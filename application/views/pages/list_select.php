<?php
echo "<div class = 'center'> ".validation_errors()." </div>"; 
$this->load->helper('html');
$this->load->helper('url');
echo form_open('pages/view_list');
$i=1;
echo "<center><br>Select List <br><select name = 'school' size= 20>";
foreach ($lists->result() as $row)
{
	if($i == 1){
		echo "<option value = ".$row->scid."|".$row->grade." selected=\"selected\"> \"".$row->name."\" ".$row->grade." enrollment year </option> ";
	}
	else{
		echo "<option value = ".$row->scid."|".$row->grade."> \"".$row->name."\" ".$row->grade." enrollment year </option> ";
	}
	$i++;
}
echo "</select><br>";
echo "<input type = \"submit\" name = \"submit\" value = \"View List\">";
echo "</center></form>";

?>