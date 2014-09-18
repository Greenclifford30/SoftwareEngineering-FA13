<?php
class Pages extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('model');
		$this->load->library('javascript');
	}
	
	function view($page = 'application')
	{
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['open_lists'] = $this->model->get_open_schools();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/tabs');
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	
	
	
	public function create()
{
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	
	$data['title'] = 'submit';

	$this->form_validation->set_rules('stID[]', 'Student ID', 'required|is_unique[student.stid]');
	$this->form_validation->set_rules('date[]', 'Date Of Birth', 'required');
	$this->form_validation->set_rules('Hschool', 'Home School', 'required');
	$this->form_validation->set_rules('Pfname', 'Parents First Name', 'required|alpha');
	$this->form_validation->set_rules('Plname', 'Parents Last Name', 'required|alpha');
	$this->form_validation->set_rules('STfname[]', 'Pupils First Name', 'required|alpha');
	$this->form_validation->set_rules('STlname[]', 'Pupils Last Name', 'required|alpha');
	$this->form_validation->set_rules('street', 'Street', 'required');
	$this->form_validation->set_rules('city', 'City', 'required|alpha');
	$this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]');
	$this->form_validation->set_rules('HPhone', 'Home Phone', 'required|exact_length[12]');
	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	
	$info = $this->input->post();
	$data = array('info' => $info);
	
	if ($this->form_validation->run() == FALSE)
	{
		$this->load->view('templates/header', $data);
		$this->load->view('templates/tabs');
		$this->load->view('pages/application', $data);
		$this->load->view('templates/footer', $data);

	}
	else
	{
		$data['identifier'] = $this->model->insert_entry($info);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/tabs');
		$this->load->view('pages/success',$data);
		$this->load->view('templates/footer', $data);
	}
}	

	public function main_login(){
	
		$this->load->library('session');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['title'] = 'Login';
		$this->form_validation->set_rules('user_name', 'Username', 'required|integer');
		$this->form_validation->set_rules('user_pass', 'Password', 'required');
	
		if ($this->form_validation->run() == FALSE){
			
			$this->load->view('templates/header',$data);
			$this->load->view('templates/tabs');
			$this->load->view('pages/login');
			$this->load->view('templates/footer');
		}
		else
		{
			$check = $this->model->validate_user();
			
			if($check == true){
				$data['fname'] = $this->session->userdata('fname');
				$data['lname'] = $this->session->userdata('lname');
				$data['role'] = $this->session->userdata('role');
				$data['empid'] = $this->session->userdata('id');	
				$data['title'] = 'Admin';
				$this->load->view('templates/header',$data);
				$this->load->view('pages/admin',$data);
				$this->load->view('templates/footer');
			}
			else
			{
				$this->load->view('templates/header',$data);
				$this->load->view('templates/tabs');
				$this->load->view('pages/login');
				$this->load->view('templates/footer');	
			}
		}
	
	}
	
public function req($page = 'numStud')
	{
		$data['title'] = ucfirst($page); 
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('form_validation');	
		
		$this->form_validation->set_rules('children', 'Children', 'required|integer|less_than[9]');
		
		if ($this->form_validation->run() == FALSE){
			
			$data['school_name'] = $this->model->schoolname();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/tabs');
			$this->load->view('pages/numStud');
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$info = $this->input->post();
			$result = $this->model->exist($info); 
			//print_r($result);
			if($result == 2 || $result == 3)
			{
				$data['result'] = $result;
				
				$data['school_name'] = $this->model->schoolname();
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/tabs');
				$this->load->view('pages/numStud', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				$data = array('info' => $info); 

				$this->load->view('templates/header', $data);
				$this->load->view('templates/tabs');
				$this->load->view('pages/application', $data);
				$this->load->view('templates/footer', $data);
			}
			
		}
	}
public function manage($page = 'admin')
	{
		$data['title'] = ucfirst($page); 

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('templates/footer', $data);
	}
	
	public function lottery_view()
	{
		$data['title'] = 'Lottery';

		$data['get_schools'] = $this->model->get_schools();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/lottery', $data);
		$this->load->view('templates/footer');
	}	

	public function app_open()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Open period';

		$data['title'] = 'Lottery';
		$this->model->set_open();
		$data['get_schools'] = $this->model->get_schools();
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/lottery', $data);
		$this->load->view('templates/footer');
	}
	
	public function app_close()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Close period';

		$data['title'] = 'Lottery';
		$this->model->set_close();
		$data['get_schools'] = $this->model->get_schools();
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/lottery', $data);
		$this->load->view('templates/footer');
	}

	public function lottery_run()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Run lottery';
		
		$data['title'] = 'Lottery';
		$this->model->set_lottery();

		$data['get_schools'] = $this->model->get_schools();
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/lottery', $data);
		$this->load->view('templates/footer');
	}	

	public function lottery_create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('year', 'Enrollment Year', 'required');
		$this->form_validation->set_rules('school', 'School', 'required');
		$this->form_validation->set_rules('attend', 'Attending Students', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Create Lottery';
			$data['schools'] = $this->model->list_schools();
		
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin');
			$this->load->view('pages/add_lottery', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$data['error'] = $this->model->create_lottery();
			if ($data['error'] == false)
			{
				$data['title'] = 'Create Lottery';
				$data['schools'] = $this->model->list_schools();
			
				$this->load->view('templates/header', $data);
				$this->load->view('pages/admin');
				$this->load->view('pages/add_lottery', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$data['get_schools'] = $this->model->get_schools();
				$data['title'] = 'Lottery';
				$this->load->view('templates/header', $data);
				$this->load->view('pages/admin');
				$this->load->view('pages/lottery', $data);
				$this->load->view('templates/footer');
			}
		}
	}
	
	public function view_list()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('school', 'School', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'View Lists';
			$data['lists'] = $this->model->get_lists();
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin');
			$this->load->view('pages/list_select', $data);
			$this->load->view('templates/footer'); 
		}
		else
		{
			$school = explode("|",$this->input->post('school'));
			$data['title'] = 'View Lists';
			$data['items'] = $this->model->that_list($school[0],$school[1]);
			$data['grade'] = $school[1];
			$data['scid'] = $school[0];
			$data['scname'] = $this->model->school_name($school[0]);
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin');
			$this->load->view('pages/list_viewer', $data);
			$this->load->view('templates/footer');
		} 
	}
	
	public function view_public()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('school', 'School', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'View Lists';
			$data['lists'] = $this->model->get_lists();
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/tabs');
			$this->load->view('pages/public_select', $data);
			$this->load->view('templates/footer'); 
		}
		else
		{
			$school = explode("|",$this->input->post('school'));
			$data['title'] = 'View Lists';
			$data['items'] = $this->model->that_list($school[0],$school[1]);
			$data['grade'] = $school[1];
			$data['scname'] = $this->model->school_name($school[0]);
			$this->load->view('templates/header', $data);
			$this->load->view('templates/tabs');
			$this->load->view('pages/public_viewer', $data);
			$this->load->view('templates/footer');
		} 
	}
	
		public function notifications()
	{
		$data['title'] = 'Notifications';

		$data['accepted'] = $this->model->get_accepted();
		$data['notified'] = $this->model->get_notified();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/notifications', $data);
		$this->load->view('templates/footer');
		
	}
	
	public function to_notify()
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('identifier', ' Selecting an application', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Notifications';

			$data['accepted'] = $this->model->get_accepted();
			$data['notified'] = $this->model->get_notified();
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin');
			$this->load->view('pages/notifications', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$data['title'] = 'Notifications';

			$data['app'] = $this->model->get_app();
			$data['status'] = $this->input->post('status');
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin');
			$this->load->view('pages/noti_app', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function notified()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['title'] = 'Notifications';
		
		$this->model->set_notified();
		$data['app'] = $this->model->get_app();
		$data['status'] = $this->input->post('status');
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/noti_app', $data);
		$this->load->view('templates/footer');
	}
	
	public function enrolled()
	{
		$data['title'] = 'Notifications';
		
		$this->model->set_enrolled();
		$data['accepted'] = $this->model->get_accepted();
		$data['notified'] = $this->model->get_notified();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/notifications', $data);
		$this->load->view('templates/footer');
	}
	
	public function send_email()
	{
		$this->load->library('email');
		$this->load->helper('email');
		
		$this->email->from('bcoledeadly@hotmail.com', 'Lottery School System');
		$this->email->to($this->input->post('cemail'));
		$subject = "Accepted to ".$this->input->post('sname');
		$this->email->subject($subject);
		$this->email->message($this->input->post('email'));	
		
		//dosnt seem to work with babbage
		//$this->email->send();
		
		$data['title'] = 'Notifications';
		$this->model->set_notified();
		$data['app'] = $this->model->get_app();
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/noti_app', $data);
		$this->load->view('templates/footer');
		
	}
	
	public function delete_noti()
	{
		$data['title'] = 'Notifications';
		$this->model->delete($this->input->post('identifier'));
		$data['accepted'] = $this->model->get_accepted();
		$data['notified'] = $this->model->get_notified();
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/notifications', $data);
		$this->load->view('templates/footer');
	}
	
		public function delete_list()
	{
		$result = $this->model->that_list($this->input->post('scid'),$this->input->post('grade'));
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				$this->model->delete($row->identifier);
			}
		}
		
		$this->db->where('scid', $this->input->post('scid') );
		$this->db->where('grade', $this->input->post('grade') );
		$this->db->delete('years');
		
		$data['title'] = 'View Lists';
		$data['lists'] = $this->model->get_lists();
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin');
		$this->load->view('pages/list_select', $data);
		$this->load->view('templates/footer'); 
	}
	
}

?>
	
