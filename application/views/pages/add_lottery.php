<?
echo "<div class = 'center'> ".validation_errors()." </div>"; 
if (isset($error))
{
	if ($error == false)
	{
			echo "<div class = 'center'><p> The School and year chosen already has a lottery! </p></div>"; 
	}
}
?>
<center>Create a new lottery for applicants to register for<br>
<?php
echo form_open('pages/lottery_create');
echo "Select School <select name = 'school'>";
foreach ($schools->result() as $row)
{
   echo "<option value = ".$row->scid."> ".$row->name."</option> ";
}
echo "</select><br>";
$x=	date("Y",strtotime("-5 years"));
$y= date("Y",strtotime("+5 years"));
?>
Select enrollment year: <input type="number" name="year" min="<?echo $x?>" max="<?echo $y?>">Enter number of attending students: <input type="number" name="attend" min="0" ><br>
<input type = "submit" name = "submit" value = "Add Lottery">
</form></center>