<?php

/**
* Page Controller
*/
class Navigation extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('patient_model');
	}

	//load login page
	public function index()
	{
		$this->load_page('login', 'index');
	}

	//load update user page
	public function update_user()
	{
		$defaultFlag = $this->session->userdata('default');
		if ($this->is_logged_in() && $defaultFlag === 1){
			$this->load_page('login', 'dashboard/update_user');
		} else if  ($this->is_logged_in() && $defaultFlag === 0) {
			redirect ( base_url('dashboard/'));
		} else {
			redirect ( base_url());
		}
   		
	}

	//load dashboard page
	public function dashboard()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/index');
		}
		
		
	}

	//Load manage user page
	public function manage_user()
	{
		
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_user');
		}
		
	}

	//Load manage patient page
	public function manage_patient()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_patient');
		}
		
	}
	/*
	*Load the user edit page
	*/
	public function manage_appointment()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_appointment');
		}
        
	}

	public function reports(){

		if ($this->is_logged_in()){
			$this->load_page('dashboard','reports/prints');
		}
		
	}


	/*
	*Load the consultation page
	*/
	public function manage_consultation()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_consultation');
		}
		
	}

	/*
	* Load the custom 404 error page
	*/
    public function errorpage(){
        $this->output->set_status_header('404');
        $data['title'] = "Page not found";
        $this->load->view('errors/custom_404_error/index',$data);
    }

    /*
    *Use for loadiing main content on the dashboard
    */
	private function load_page($type, $content){
		$data['pagetitle'] = 'Aguilar Clinic | Healthcare Management System';
		$data['type'] = $type;
		$data['content'] = $this->load->view($content, null, true);
		$this->load->view('inc/template', $data);
	}

	/*
	*Check if user logged in
	*/
	private function is_logged_in()
	{
		$user = $this->session->userdata('userID');
		if ($user){
			return true;
		} else {
			redirect( base_url() );
		}
	}
}
