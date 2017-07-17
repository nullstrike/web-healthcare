<?php

class User extends CI_Controller
{
   private $user_id;
   private $user_role;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->pageredir('authenticate_view');
    }
    /*public function ret(){
        $this->pageredir('patient_view');
    }*/
    public function pageredir($page)
    {
        $data['pagetitle'] = "Healthcare Management System of Aguilar Clinic";
        $this->load->view('inc/header', $data);
        $this->load->view($page);
        $this->load->view('inc/footer');
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($rows = $this->user_model->login($username,$password)) {
            $info['success'] = true;
            foreach ($rows as $row) {
                $this->user_id = $row['user_id'];
                $this->user_role = $row['user_type'];
                $password = $row['user_userpass'];
                $username = $row['user_username'];
         }
         $this->session->set_userdata(array("user_id" => $this->user_id, "user_username" => $username));
        if($password === "default"){
               $info['page'] = "user/user_edit";
        }else{
            if($this->user_role !== "admin"){
                $info['page'] = "user/user_staff";
            }else{
                $info['page'] = "user/user_admin";
            }
        }
        }else{
            $info['success'] = false;
            $info['message'] = "login failed";
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($info));
    }

    public function admin()
    {
        $this->pageredir('test');
    }

    public function user_edit()
    {
        $this->pageredir('user_edit');
    }

    public function user_admin(){
        $this->pageredir('admin');
    }

    public function user_update()
    {

        $this->form_validation->set_rules($this->validates());

        if ($this->form_validation->run() === FALSE) {
            $error = array();
            $info['success'] = false;
            foreach($this->input->post() as $key => $value){
                array_push($error, form_error($key));
            }
            $info['errors'] = array_filter($error);
        } else {
            $id = $this->input->post('id');
            $info['success'] = true;
            $this->user_model->user_update($id, $this->form_input());
            $info['message'] = "Successfully added user detail";
            $info['page'] = "/healthcare/";
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($info));
    }

    public function form_input()
    {
        $data = array(
            "user_firstname" => $this->input->post('firstname'),
            "user_middlename" => $this->input->post('middlename'),
            "user_lastname" => $this->input->post('lastname'),
            "user_username" => $this->input->post('username'),
            "user_userpass" => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            "user_contact" => $this->input->post('contact'),
            "user_type" => $this->input->post('job')
        );
        return $data;
    }

    public function validation_rules($field, $label, $rules)
    {
        $rule = array(
            "field" => $field,
            "label" => $label,
            "rules" => $rules
        );
        return $rule;
    }

    public function validates()
    {

        $rules = array($this->validation_rules('firstname', 'firstname', 'trim|required|callback__name_check'),
            $this->validation_rules('middlename', 'middlename', 'trim|required|callback__name_check'),
            $this->validation_rules('lastname', 'lastname', 'trim|required|callback__name_check'),
            $this->validation_rules('contact', 'contact number', 'trim|required|callback__number_check'),
            $this->validation_rules('password', 'password', 'trim|required|callback__password_check'),
            $this->validation_rules('confpassword', 'confirm password', 'trim|required|matches[password]')
        );

        return $rules;
    }

    public function _name_check($str)
    {
        if (!preg_match('/^[a-z ]+$/i', $str)) {
            $this->form_validation->set_message('_name_check', 'The {field} field must contain alphabet and spaces only ');
            return false;
        }
        return true;
    }

    public function _date_check($date)
    {
        $part = explode('/', $date);
        if (count($part) === 3) {
            if (checkdate($part[0], $part[1], $part[2])) {
                return true;
            }
        } else {
            $this->form_validation->set_message('_date_check', 'The {field} field must only contain a dd/mm/yyyy date format');
            return false;
        }
    }

    public function _number_check($str)
    {

        if (!preg_match('/^\+?\d*$/', $str)) {
            $this->form_validation->set_message('_number_check', 'The {field} field must only contain numeric and plus sign');
            return false;
        } else {
            return true;
        }
    }

    public function _password_check($str)
    {
        if (!preg_match('/[a-z]/', $str)
            && !preg_match('/[0-9]/', $str) && !preg_match('/[A-Z]/', $str)
        ) {
            $this->form_validation->set_message('_password_check', 'The {field} field must contain an uppercase,lowercase and a number');
            return false;
        } else {
            return true;
        }
    }

    public function user_add(){
        $this->user_model->user_add($this->form_input());
        echo json_encode("success");
    }
}