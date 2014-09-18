<script type="text/javascript">
 $(function(){$("textarea.tinymce").tinymce({
	// Location of TinyMCE script
	script_url : "<?php echo base_url('js/tinymce/tinymce.min.js'); ?>",
    width: 500,
	height : 300,
	remove_linebreaks : false 
});}); 
</script>
<?
	//this view displays application data for employee to use when sending notifications
	$app1 = $app->row();
	//application info
	echo "<center><h3>Application</h3>";
	echo "<hr width='40%'>";
	echo "<h4>Application: AY".$app1->iyear.$app1->identifier."</h4>";
	echo "<h4>School: ".$app1->name." <br>Lottery Year: ".$app1->grade."</h4>";
	if($app1->notified != null)
	{
		echo "Last notified at: ".$app1->notified."";
	}
	echo "<br><br>";
	echo "<table>";
	//student info
	echo "<tr><td><h3>Students associated with application</h3>";
	echo "<hr width='70%'><table>";
	echo "<tr><th>Student ID</th><th>Name</th></tr>";
	foreach($app->result() as $row){
		echo "<tr><td>".$row->stid."</td><td>".$row->slname.", ".$row->sfname."</td></tr>";
	}
	echo "</table></td>";
	//contact info
	echo "<td><h3>Parent or Guardian Contact Information </h3>";
	echo "<hr width='70%'>";
	echo "Name: ".$app1->alname.", ".$app1->afname."<br>";
	echo "Address: ".$app1->street.", ".$app1->city.", ".$app1->zip."<br>";
	echo "Home Phone: ".$app1->hphone."<br>";
	echo "Work Phone: ".$app1->wphone."<br>";
	echo "Office Phone: ".$app1->ophone."<br>";
	echo "email: ".$app1->email."<br>";
	switch ($app1->prefcont){
		case "e":
			echo "Preferred contact method is E-mail";
			break;
		case "h":
			echo "Preferred contact method is home phone";
			break;
		case "w":
			echo "Preferred contact method is work phone";
			break;
		case "o":
			echo "Preferred contact method is office phone";
			break;
		case "l":
			echo "Preferred contact method is a mailed letter";
			break;
	}
	echo "</td></tr></table>";
	
	if ($app1->notified == NULL){
		echo "<div class=\"btn_cont\">";
		echo anchor('pages/notifications', 'Close', 'class="button"');
		echo form_open('pages/notified');
		echo form_hidden('identifier',$app1->identifier);
		echo form_submit('submit', 'Notified');
		echo form_close("</div>");
	}
	else
	{
		echo "<div class=\"btn_cont\">";
		echo anchor('pages/notifications', 'Close', 'class="button"');
		echo form_open('pages/notified');
		echo form_hidden('identifier',$app1->identifier);
		echo form_submit('submit', 'Notified');
		echo form_close();
		echo form_open('pages/enrolled');
		echo form_hidden('identifier',$app1->identifier);
		echo form_submit('submit', 'Enroll');
		echo form_close ();
		echo form_open ('pages/delete_noti');
		echo form_hidden('identifier',$app1->identifier);
		echo form_submit('submit', 'Delete Application');
		echo form_close("</div>");
	}
	echo "<br>";
	echo "<h2>Email Notification</h2>";
	$email = read_file('./application/views/templates/acceptance.txt');
	
	echo form_open('pages/send_email');
	$datam = array(
              'name'        => 'email',
              'value'       => $email,
              'rows'   		=> '10',
              'cols'        => '1',
			  'class'		=> 'tinymce'
            );
	echo form_textarea($datam);
	$datah = array(
		'cemail' => $app1->email,
		'sname' => $app1->name,
		'identifier' => $app1->identifier
	);
	echo form_hidden ($datah);
	echo "<br>";
	echo form_submit('email', 'Send Email');
	echo form_close();
	echo "</center>";
?>