<?php
$this->load->helper('html');
$this->load->helper('url');
$this->load->helper('form');
echo validation_errors();
echo "<center><div id=\"noticont\">";
	echo "<div id=\"notiact\"><center>";
	echo "<h3>Accepted</h3>";
	if ($accepted->num_rows() > 0){
		echo form_open("pages/to_notify");
		echo "Select Application <br><select name = 'identifier' size = 30>";
		foreach($accepted->result() as $row)
		{
			echo "<option value = " .$row->identifier. " > ".$row->name."  ".$row->grade."  AY".$row->iyear.$row->identifier." </option>";
		}
		echo "</select><br>";
		echo form_hidden('status','accept');
		echo form_submit('submit', 'Get Info');
		echo form_close();
	}
	else
	{
		echo "No applications are pending notification.";
	}
	echo "</center></div>";
 	echo "<div id=\"notinoti\"><center>";
	echo "<h3>Notified</h3>";
	if ($notified->num_rows() > 0){
		echo form_open("pages/to_notify");
		echo "Select Application <br><select name = 'identifier' size = 30>";
		foreach($notified->result() as $row)
		{
			echo "<option value = " .$row->identifier. " > ".$row->name."  ".$row->grade."  AY".$row->iyear.$row->identifier." </option>";
		}
		echo "</select><br>";
		echo form_hidden('status','notified');
		echo form_submit('submit', 'Get Info');
		echo form_close();
	}
	else
	{
		echo "No applications are pending a reply.";
	}
	echo "</center></div>"; 
echo "</div></center>";
?>