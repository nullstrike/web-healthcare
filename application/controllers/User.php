<?php

/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/5/17
 * Time: 12:47 PM
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
       $this->pageredir('authenticate_view');
    }
    public function pageredir($page){
        $data['pagetitle'] = "Healthcare Management System of Aguilar Clinic";
        $this->load->view('inc/header',$data);
        $this->load->view($page);
        $this->load->view('inc/footer');
    }
    public function authenticate()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('upass');

        if ($this->user_model->auth($username, $password)) {
            redirect('/user/user_edit','location','refresh');
        }else {
            echo "failed";
        }
    }
    public function user_edit(){
        $this->pageredir('user_edit');
    }
    public function user_update()
    {
        $lname = $this->input->post('lname');
        $data = array(
            "user_lastname" => $lname
        );
        $key = array("user_username" => "doctor");
        echo $this->user_model->update_user($key, $data);
    }
}