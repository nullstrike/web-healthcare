<?php

/**
* Page Controller
*/
class Navigation extends CI_Controller
{

	protected $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model'); 
		$this->load->model('patient_model');
		$this->load->helper('url');
	}

	/*
	*Load the index page
	*/
	public function index()
	{
		$this->load->view('index');
	}
    

	/*
	*Load the update user page
	*/
    public function edit(){
        $this->load->view('dashboard/update_user');
    }

	/*
	*Load the admin dashboard page
	*/
	public function dashboard()
	{
		$this->page('dashboard/index');
	} 

	/*
	*Load the manage user page
	*/
	public function user()
	{
        $this->page('dashboard/manage-user');
	}

	/*
	*Load the user edit page
	*/
	public function appointment()
	{
        $this->page('dashboard/appointment');
	}

	/*
	*Load the patient page
	*/
	public function patient()
	{
		$this->page('dashboard/manage-patient');
	}

	/*
	*Load the patient info page
	*/
	public function patient_info()
	{
		$this->page('dashboard/patient_info');
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
    *Load the consultation page
    */
    public function consultation()
    {
    	$this->page('dashboard/consultation');
    }
    /*
    *Use for loadiing main content on the dashboard
    */
    private function page($content = 'dashboard/index', $page = 'inc/main')
    {
        $year = getdate();
        $this->data['pagetitle'] = 'Healthcare Management System of Aguilar Clinic';
        $this->data['copy'] = 'Aguilar Clinic &copy; ' . $year['year'];
        $this->data['content']  = $this->load->view($content,'',TRUE);

        $this->load->view('inc/header', $this->data);
        $this->load->view($page, $this->data);
        $this->load->view('inc/footer', $this->data);

    }
}