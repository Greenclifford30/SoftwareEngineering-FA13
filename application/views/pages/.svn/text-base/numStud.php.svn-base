<?php 
	$this->load->helper('form');
	$this->load->helper('html');
	
	if(isset($result))
	{
		//echo $result;
		if($result ==  2)
		{
			echo "Your student is too young to apply.";
		}
		if($result == 3)
		{
			echo "List does not exist"; 
		}
	}
	echo link_tag('css/appstyle.css');
	$string = "<div></div>";
	
	$data = array(
	'name' => 'children', 
	'placeholder' => 'Max 8',
	'type' => 'number',
	'min' => '1',
	'max' => '8'
	);
	$options = array( 
		'0' => 'K',
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5'
		);
	$att = array(
	'class' => 'fields'
	);
	echo validation_errors();
	
	echo form_open("pages/req");
	
	echo form_fieldset('Prerequisites', $att);
	echo "<center>";
	echo "Select School <select name = 'School'>";
	foreach($school_name->result() as $row)
	{
		echo "<option value = " .$row->scid. " > ".$row->name." </option>";
	}
	echo "</select>";
	echo br(2);
	echo form_label('Enter Students Grade: ', 'grade'); 
	echo form_dropdown('grade', $options);
	echo br(2);
	echo  form_label('Enter total children applying:', 'children');
	echo nbs(4);
	echo form_input($data); 
	echo br(2);
	echo form_fieldset_close();
	echo "</center>";
	echo "<center>";
	echo form_submit('submit', 'Submit');
	echo nbs(3);
	echo anchor('', 'Cancel');
	
	echo "</center>";
	
	echo form_close($string);	

	
	
