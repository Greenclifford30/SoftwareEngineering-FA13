<?php
echo "<div class='tabs'>";

	//echo "<div class='button'>";
	echo anchor('pages/view','Home', array('class' => 'button'));
	//echo "</div>";
	
	//echo "<div class='button'>";
	echo anchor('pages/req','Application', array('class' => 'button'));
	//echo "</div>";
	
	//echo "<div class='button'>";
	echo anchor('pages/view_public','Wait Lists', array('class' => 'button'));
	//echo "</div>";
	
	//echo "<div class='button'>";
	echo anchor('pages/#','Contact Information', array('class' => 'button'));
	//echo "</div>";
	
echo "</div>";
?>
