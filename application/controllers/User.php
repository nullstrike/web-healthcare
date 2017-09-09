<?php

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper('url');
    }

    /*
     * use: inserts data into database
     * given the form validation result
     * returns to true and encode a json
     * response to be used on callback
     */
    public function userInsert()
    {

        $this->form_validation->set_rules('firstname', 'first name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('lastname', 'last name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('username', 'username', 'rtrim|required|alpha_numeric|is_unique[user.userName]');

        $data = array(
            "firstname" => $this->input->post('firstname'),
            "lastname" => $this->input->post('lastname'),
            "username" => $this->input->post('username'),
            "password" => 'default',
            "usertitle" => 'receptionist'
        );
        if ($this->form_validation->run()){
            $response['success'] = true;
            $response['message'] = "Successfully added user";
            $this->user_model->userInsert($data);
        } else {
            $response['errors'] = $this->form_validation->error_array();
            $response['success'] = false;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /*
     * use: validate user account and
     * will store data into the session
     * then encode the json response to
     * be used for callback. the password
     * that is set to default will redirect
     * to change password page
     */
   public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run()) {
            if ($query = $this->user_model->authenticate($username, $password)) {
                $session = array();
                foreach ($query as $row) {
                    $session['userName'] = $row->username;
                    $session['name'] = $row->firstname . ' ' .  $row->lastname;
                    $session['userID'] = $row->id;
                    $session['userTitle'] = $row->usertitle;
            
                }
               
                if ($password === "default") {
                    $session['default'] = 1;
                    $response['page'] = 'user/update';
                } else {
                    $session['default'] = 0;
                    $response['page'] = 'dashboard/';
                }
                
                $response['success'] = true;
                $this->session->set_userdata($session);
                
                // $data = array(
                //     'userID' => $session['userID'],
                //     'log_datetime' => date('Y-m-d H:i:s')
                // );

                // $query = $this->user_model->checkuserLog($session['userID']);
                // if ($query === 0) {
                //     $this->user_model->createuserLog($data);
                // } else if ($query === 1) {
                //     $this->user_model->updateuserLog($session['userID'], $data['log_datetime']);
                // }

            } else {
                $response['success'] = false;
                $response['message'] = "Username or password is incorrect";
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /*
    *use: log outs the user
    *destroying its session data
    */
    public function user_logout()
    {
        $this->session->sess_destroy();
        redirect( base_url() );
    }

    /*
     * use: update user data give
     * the current password is default
     * destroys the session and encode
     * a json response for callback
     */
    public function userUpdate()
    {
        $this->form_validation->set_rules('userPass', 'password', 'trim|required');
        $this->form_validation->set_rules('userpassConf', 'confirm password', 'required|matches[userPass]');
        $data = array ("password" => password_hash($this->input->post('userPass'),PASSWORD_BCRYPT));


        if ($this->form_validation->run()) {
            $id = $this->input->post('userId');
            $response['success'] = true;
            $response['page'] = base_url();
            $this->user_model->userUpdate($id, $data);
            session_destroy();
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /*
    *Update the default info of admin
    */
    public function doctorUpdate()
    {
        $this->form_validation->set_rules('firstName', 'first name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('lastName', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('userPass', 'password', 'required');
        $this->form_validation->set_rules('userpassConf', 'confirm password', 'required|matches[userPass]');
        $this->form_validation->set_rules('contactNum', 'contact number', 'required|numeric');
        
        $data = array(
                      'firstname' => $this->input->post('firstName'),
                      'lastname'  => $this->input->post('lastName'),
                      'password'  => password_hash($this->input->post('userPass'), PASSWORD_BCRYPT),
                      'contact'   => $this->input->post('contactNum')
        );
        
        if ($this->form_validation->run()) {
            $userID = $this->input->post('userID');
            $this->user_model->userUpdate($userID, $data);
            $response['success'] = true;
            $response['page'] = base_url();
            $this->session->set_flashdata('alert', 'Successfully updated user');
            session_destroy();
        } else {
            $response['success'] = false;
            $response['errors'] = validation_errors();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /*
    *Fetch user records
    */
    public function getUserRecord()
    {
        $query = $this->user_model->userFetch()->result_array();
        $users = array();
        foreach ($query as $rows) {
            $row = array();
            $row[] = $rows['id'];
            $row[] = $rows['firstname'];
            $row[] = $rows['lastname'];
            $row[] = $rows['username'];
            $row[] = $rows['usertitle'];
            $users[] = $row;
        }
      return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $users)));
    }

    public function getOneRecord()
    {
        $key = array('id' => $this->input->get('id'));
        $query = $this->user_model->userFetch($key)->result();
          foreach ($query as $rows) {
               $row[] = $rows->firstname;
               $row[] = $rows->lastname;
               $row[] = $rows->username;
           }
        return $this->output->set_content_type('application/json')->set_output(json_encode($row));
    }
    /*
    *The following are only used in validation
    */
    public function _name_check($str)
    {
        if (!preg_match('/^[a-z ]+$/i', $str)) {
            $this->form_validation->set_message('_name_check', 'The {field} must have letters and spaces only');
            return false;
        }
        return true;
    }



}
