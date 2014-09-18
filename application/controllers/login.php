<?php
/*
 *public function create_login()
{
	$this->load->helper('form');
	$this->load->library('form_validation');

	$data['title'] = 'submit';

	$this->form_validation->set_rules('element_1', 'Username', 'required');
	$this->form_validation->set_rules('element_2', 'Password', 'required');


	if ($this->form_validation->run() == FALSE)
	{
		$this->load->view('templates/header', $data);
		$this->load->view('pages/login');
		$this->load->view('templates/footer');

	}
	else
	{
	/*	$data['identifier'] = $this->model->insert_entry();
		$this->load->view('pages/success',$data);
	}
}
*/
if( ! defined('basepath')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->helper(array('form'));
        $this->load->veiw('pages/login');        
    }
    
}


?>