<?php echo "<div class = 'center'> ".validation_errors()." </div>"; 
$this->load->helper('html');
$this->load->helper('url');
$this->load->helper('form');
echo link_tag('css/appstyle.css');
//Definitions of arrays being used as options for form data

$id = array(
		'name' => 'stID[]',
		'class' => 'input',
		'placeholder' => 'Student Id'
);
$dob = array(
	'name' => 'date[]',
	'type' => 'date',
	'placeholder' => 'mm/dd/yyyy',
	'class' => 'input'
);
$hs = array(
	'name' => 'Hschool',
	'class' => 'input'
);
$pf = array(
	'name' => 'Pfname',
	'placeholder' => 'First Name',
	'class' => 'input'
);
$pl = array(
	'name' => 'Plname',
	'placeholder' => 'Last Name',
	'class' => 'input'
);
$sf = array(
	'name' => 'STfname[]',	
	'placeholder' => 'First Name',
	'class' => 'input'
);
$sl = array(
	'name' => 'STlname[]',
	'placeholder' => 'Last Name',
	'class' => 'input'
);
$street = array(
	'name' => 'street',
	'placeholder' => 'Street',
	'class' => 'input'	
);
$city = array(
	'name' => 'city',
	'placeholder' => 'city',
	'class' => 'input'
);
$zip = array(
	'name' => 'zip',
	'placeholder' => 'Zip Code',
	'class' => 'input'
);
$hp = array(
	'name' => 'HPhone',
	'type' => 'tel',
	'placeholder' => 'ex. xxx-xxx-xxxx',
	'class' => 'input'	
);
$op = array(
	'name' => 'Ophone',
	'type' => 'tel',
	'placeholder' => 'ex. xxx-xxx-xxxx',
	'class' => 'input'
);
$wp = array(
	'name' => 'Wphone',
	'type' => 'tel',
	'placeholder' => 'ex. xxx-xxx-xxxx',
	'class' => 'input'	
);
$email = array(
	'name' => 'email',
	'placeholder' => 'email@example.com',
	'class' => 'input'
);
$att = array(
	'class' => 'fields'
);
$form = array(
	'class' => 'fields'
);
//End of definitions

echo "<div class = 'center'>";
echo form_open('pages/create');
//Create hidden variables to pass information from 'pages/req'
echo form_hidden('School',$info['School']);
echo form_hidden('children', $info['children']);
echo form_hidden('grade', $info['grade']); 
echo br(2);
echo form_fieldset('Student Information', $att);

echo "<div class = 'center'>";
echo form_label('Pupils Name: ', 'STfname'); 
//Last for loop handles students first and last name
for($i=1; $i <= $info['children']; $i++)
{
	echo $i;
	echo form_input($sf);
	echo nbs(8);
	echo form_input($sl);
	echo nbs(5); 
}
echo br(2);
echo form_label('Enter Student #: ', 'stID'); 
//Loops to create dynamic form for multiple students applying at once
for($i=1; $i <= $info['children']; $i++)
{
	
	echo $i;
	echo form_input($id);
	echo nbs(10);	
}
echo "<div>";
echo br(2);
echo "<div class = 'center'>";
echo form_label('Students Date of Birth :', 'date');
//Loop to create dynamic form for students dob
for($i=1; $i <= $info['children']; $i++)
{	
	echo $i;
	echo form_input($dob);
	echo nbs(10);
}
echo "</div>";
echo br(2);
echo form_label('Enter Home School: ','Hscool');
	echo form_input($hs);
echo form_fieldset_close();
echo br(1);
echo form_fieldset('Contact Information', $att);
echo br(2);
echo "<div class = 'center'>";
echo form_label('Parents Name', 'Pfname'); 
//inputs for parents first and last name
echo form_input($pf);
echo nbs(10);
echo form_input($pl);

echo br(2); 
echo form_label('Address:', 'street'); 
//Forms address information
echo form_input($street); 
echo nbs(5);
echo form_input($city);
echo nbs(5);
echo form_input($zip);

echo heading('Phone', 3); 
//Applicant phone & email information
echo form_label('Home Phone: ', 'Hphone');
echo form_input($hp); 
echo nbs(5);
echo form_label('Office Phone: ', 'Ophone');
echo form_input($op);
echo nbs(5);
echo form_label('Work Phone: ', 'Wphone');
echo form_input($wp);
echo br(2);
echo form_label('Email: ' , 'email'); 
echo form_input($email);
echo "</div>";
echo form_fieldset_close();
echo "<div class = 'center'>";
echo form_fieldset('Preferred form of contact', $att);
?>
	<input type = "radio" name = "prefCont" value = "e" checked=true>Email <br>
	<input type = "radio" name = "prefCont" value = "h" > Home Phone <br>
	<input type = "radio" name = "prefCont" value = "w" > Work Phone <br>
	<input type = "radio" name = "prefCont" value = "o" > Office Phone <br>
	<input type = "radio" name = "prefCont" value = "l" > Letter <br> 
	<?php echo br(); ?>
	<input type = "submit" name = "submit" value = "Submit Application"> 
	<?php echo anchor(' ', 'Cancel');
echo form_fieldset_close();
echo form_close();?>
</div>
</form>
</div>

