<?php

/**
* Page Controller
*/
class Navigation extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Load index page
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load_page('login', 'index');
	}

	/**
	 * Load update user page
	 *
	 * @return void
	 */
	public function update_user()
	{
		//store session default variable
		$defaultFlag = $this->session->userdata('default');

		//check if user is logged in and user is default
		// if user is not logged in redirect to index page
		// if user is default load Update user page
		// else load the dashboard index
		if ($this->is_logged_in() && $defaultFlag === 1) {
			$this->load_page('login', 'dashboard/update_user');
		} else if  ($this->is_logged_in() && $defaultFlag === 0) {
			redirect ( base_url('dashboard/'));
		} else {
			redirect ( base_url());
		}

	}

	/**
	 * Load dashboard index page
	 *
	 * @return void
	 */
	public function dashboard()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/index', 'dashboard');
		}
	}

	/**
	* Load the userlog page
	*
	*@return void
	*/
	public function userlog()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/userlog', 'userlog');
		}
	}
	/**
	 * Load the manage user page
	 *
	 * @return void
	 */
	public function manage_user()
	{
	    //store session userTitle variable
		$type = $this->session->userdata('userTitle');

		//redirect user to dashboard index if usertitle is receptionist
		if ($this->is_logged_in($type)){
			$this->load_page('dashboard', 'dashboard/manage_user', 'user');
		} else {
			redirect ( base_url('/dashboard') );
		}

	}

	/**
	 * Load the manage patient page
	 *
	 * @return void
	 */
	public function manage_patient()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_patient', 'patient');
		}

	}

	/**
	 * Load the manage appointment page
	 *
	 * @return void
	 */
	public function manage_appointment()
	{
		if ($this->is_logged_in()){
			$this->load_page('dashboard', 'dashboard/manage_appointment', 'appointment');
		}

	}

	/**
	 * Load the manage report page
	 *
	 * @return void
	 */
	public function manage_report(){

		if ($this->is_logged_in()){
			$this->load_page('dashboard','dashboard/manage_reports', 'report');
		}

	}

	/**
	 * Load the manage consultation page
	 *
	 * @return void
	 */
	public function manage_consultation()
	{
		$type = $this->session->userdata('userTitle');
		if ($this->is_logged_in($type)){
			$this->load_page('dashboard', 'dashboard/manage_consultation', 'consultation');
		}  else {
			redirect ( base_url('/dashboard') );
		}

	}

	/**
	 * Load the custom error page
	 *
	 * @return void
	 */
    public function errorpage(){
        $this->output->set_status_header('404');
        $data['title'] = "Page not found";
        $this->load->view('errors/custom_404_error/index',$data);
    }

    /**
	 * Loading page on the template on paramaters passed
	 *
	 * @param string $type
	 * @param string $content
	 * @param string $section
	 * @return void
	 */
	private function load_page($type, $content, $section = null){
		$data['pagetitle'] = 'Aguilar Clinic | Healthcare Management System';
		$data['type'] = $type;
		$data['content'] = $this->load->view($content, null, true);
		$data['section'] = $section;
		$this->load->view('inc/template', $data);
	}

	/**
	 * Check if user logged in
	 *
	 * @param string $type
	 * @return boolean
	 */
	private function is_logged_in($type = null)
	{
		$user = $this->session->userdata('userID');
			if ($user){
				if ($type === 'receptionist') {
					return false;
				} else {
					return true;
				}

			} else {
				redirect( base_url() );
			}

	}
}
