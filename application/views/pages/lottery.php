<?php
$this->load->helper('html');
$this->load->helper('url');
$this->load->helper('form');
echo "<br><br>";
echo anchor('pages/lottery_create', 'Add Lottery', 'class="button"');
if ($get_schools != false)
{
	echo "<div id=\"lot_cont\">";
   foreach ($get_schools as $row)
   {
		echo "<div class = \"lineup\"><center>".$row['name']."<br>";
		echo $row['grade']."<br>";
		echo "Applications: ".$row['studs']."<br>";
		if ($row['isopen'] == 'f'){
			echo form_open('pages/app_open');
			echo "<input type = \"hidden\" name=\"scid\" value= \"".$row['scid']."\">";
			echo "<input type = \"hidden\" name=\"grade\" value= \"".$row['grade']."\">";
			echo "<input type = \"submit\" name = \"submit\" value = \"Open Lottery Application\">"; 
			echo "</form>";
		}
		else{
			echo form_open('pages/lottery_run');
			echo "<input type = \"hidden\" name=\"scid\" value= \"".$row['scid']."\">";
			echo "<input type = \"hidden\" name=\"grade\" value= \"".$row['grade']."\">";
			echo "<input type = \"submit\" name = \"submit\" value = \"Run Lottery\">"; 
			echo "</form>";
			echo form_open('pages/app_close');
			echo "<input type = \"hidden\" name=\"scid\" value= \"".$row['scid']."\">";
			echo "<input type = \"hidden\" name=\"grade\" value= \"".$row['grade']."\">";
			echo "<input type = \"submit\" name = \"submit\" value = \"Close Lottery Application\">"; 
			echo "</form>";
		}
	  echo "</center></div>";
	}
	echo "</div>";
}
else
{
	echo "<br><br><center>No lotteries available</center><br><br>";
}

?>