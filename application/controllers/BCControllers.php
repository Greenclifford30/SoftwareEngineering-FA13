<?php
	public function lottery_view()
	{
		$data['title'] = 'Lottery';

		$data['get_schools'] = $this->model->get_schools();
		
		$this->load->view('templates/header', $data);
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
		//what now

		$data['get_schools'] = $this->model->get_schools();
			
		$this->load->view('templates/header', $data);
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
			$this->load->view('pages/add_lottery', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$this->model->create_lottery();
			$data['title'] = 'Lottery';

			$data['get_schools'] = $this->model->get_schools();
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/lottery', $data);
			$this->load->view('templates/footer');
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
			$this->load->view('pages/list_select', $data);
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
			$this->load->view('pages/public_viewer', $data);
			$this->load->view('templates/footer');
		} 
	}
?>