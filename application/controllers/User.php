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
        $this->form_validation->set_rules('title', 'job type', 'required');

        $data = array(
            "userfirstName" => $this->input->post('firstname'),
            "userlastName" => $this->input->post('lastname'),
            "userName" => $this->input->post('username'),
            "userPassword" => 'default',
            "userTitle" => $this->input->post('title')
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
                    $session['userName'] = $row->userName;
                    $session['name'] = $row->userfirstName . ' ' .  $row->userlastName;
                    $session['userID'] = $row->userID;
                    $session['userTitle'] = $row->userTitle;
                }
                $this->session->set_userdata($session);

                if ($password === "default") {
                    $response['page'] = 'user/edit';
                } else {
                    $response['page'] = 'dashboard';
                }

                $response['success'] = true;
                $response['message'] = "Logging in...";

            } else {
                $response['success'] = false;
                $response['message'] = "Login failed";
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
        redirect('/', 'refresh');
    }

    /*
     * use: update user data give
     * the current password is default
     * destroys the session and encode
     * a json response for callback
     */
    public function userUpdate()
    {
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[password]');
        $data = array ("userPassword" => password_hash($this->input->post('password'),PASSWORD_BCRYPT));
     
       
        if ($this->form_validation->run()) {
            $id = $this->input->post('userid');
            $response['success'] = true;
            $response['message'] = "Successfully updated user password";
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
        $this->form_validation->set_rules('firstname', 'first name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[password]');
        $this->form_validation->set_rules('contact', 'contact number', 'required|numeric');
        $data = array(
                    'userfirstName' => $this->input->post('firstname'),
                    'userlastName'  => $this->input->post('lastname'),
                    'userPassword'  => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'userContact'   => $this->input->post('contact')
            );
        if ($this->form_validation->run()) {
            $userID = $this->input->post('userID');
            $this->user_model->userUpdate($userID, $data);
            $response['success'] = true;
            $response['message'] = 'Successfully updated user';
            $response['page'] = base_url();
            session_destroy();
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
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