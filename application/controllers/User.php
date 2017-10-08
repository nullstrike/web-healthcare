<?php

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * Function to create user
     *
     * @return void
     */
    public function createUser()
    {

        //server-side form validation
        $this->form_validation->set_rules('firstname', 'first name', 'trim|callback__name_check');
        $this->form_validation->set_rules('lastname', 'last name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('username', 'username', 'trim|required|alpha_numeric|is_unique[user.userName]');


        //store data to an array variable to be inserted to the database
        $user_data = array(
            "firstname" => $this->input->post('firstname'),
            "lastname" => $this->input->post('lastname'),
            "username" => $this->input->post('username'),
            "password" => 'default',
            "usertitle" => 'receptionist'
        );

        //check if form validation is success
        if ($this->form_validation->run()) {

            //set json response data
            $response['success'] = true;
            $response['message'] = "Successfully added user";

            //call createUser function from the user model
            $this->user_model->createUser($user_data);

        } else {

            //set json response data
            $response['errors'] = $this->form_validation->error_array();
            $response['success'] = false;

        }
       return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

   /**
    * Function to authenticate user
    *
    * @return void
    */
   public function authenticate()
    {
        //store post variables to another variable
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        //server-side form validation
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        //check if form validation is success
        if ($this->form_validation->run()) {

            //store and execute the authenticate function
            if ($query = $this->user_model->authenticate($username, $password)) {

                //create an array for the session data
                $session = array();

                //iterate over query result
                foreach ($query as $row) {

                    //push query result to session array
                    $session['userName'] = $row->username;
                    $session['name'] = $row->firstname . ' ' .  $row->lastname;
                    $session['userID'] = $row->id;
                    $session['userTitle'] = $row->usertitle;

                }

                //check if the user password is default
                if ($password === "default") {

                    //set session default value
                    $session['default'] = 1;

                    //set json response data
                    $response['page'] = 'user/update';
                } else {

                    //set session default value
                    $session['default'] = 0;

                    //set json response data
                    $response['page'] = 'dashboard/';
                }

                //set json response data
                $response['success'] = true;

                //set session data
                $this->session->set_userdata($session);

                //store log data to userlog array
                $userlog_data = array(
                    'userID' => $session['userID'],
                    'log_datetime' => date('Y-m-d H:i:s')
                );

                //store and execute checkuserLog function in a variable
                $log = $this->user_model->checkUserLog($session['userID']);

                //check how many query result return
                if ($log === 0) {

                    //insert user log
                    $this->user_model->createuserLog($userlog_data);

                } else if ($log === 1) {

                    //update user log
                    $this->user_model->updateUserLog($session['userID'], $userlog_data['log_datetime']);

                }

            } else {

                //set json response data
                $response['success'] = false;
                $response['message'] = "Username or password is incorrect";
            }
        } else {

            //set json response data
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
    * Get userlogs
    *
    *@return void
    */
    public function getUserLogs()
    {
      $query = $this->user_model->getUserLogs();
      $userlogs = array();

      foreach ($query as $rows) {
        $userlog = array();
        $userlog[] = $rows->usertitle;
        $userlog[] = $rows->username;
        $userlog[] = $rows->log_datetime;
        $userlogs[] = $userlog;
      }

      return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $userlogs)));
    }


    /**
     * Function to destroy session data
     *
     * @return void
     */
    public function userLogout()
    {
        $this->session->sess_destroy();
        redirect( base_url() );
    }

    /**
     * Function to update user data
     *
     * @param int $user_id
     * @return void
     */
    public function updateUser($user_id)
    {
        //server-side form validation
        $this->form_validation->set_rules('userPass', 'password', 'trim|required');
        $this->form_validation->set_rules('userpassConf', 'confirm password', 'required|matches[userPass]', array('matches' => 'Password and confirm password do not match.'));

        //encrypt password using bcrypt hashing function
        $user_data = password_hash($this->input->post('userPass'),PASSWORD_BCRYPT);

        //check if form validation is success
        if ($this->form_validation->run()) {
            //set json response data
            $response['success'] = true;
            $response['page'] = base_url();

            //update user
            $this->user_model->updateUser($user_id, array('password' => $user_data));

            //destroy current session
            session_destroy();

        } else {
            //set json response data
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Function to update
     *
     * @param int $user_id
     * @return void
     */
    public function updateDoctor($user_id)
    {
        //server-side form validation
        $this->form_validation->set_rules('firstName', 'first name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('lastName', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('userPass', 'password', 'required');
        $this->form_validation->set_rules('userpassConf', 'confirm password', 'required|matches[userPass]');
        $this->form_validation->set_rules('contactNum', 'contact number', 'required|numeric');

        //store user data to array
        $user_data = array(
                      'firstname' => $this->input->post('firstName'),
                      'lastname'  => $this->input->post('lastName'),
                      'password'  => password_hash($this->input->post('userPass'), PASSWORD_BCRYPT),
                      'contact'   => $this->input->post('contactNum')
        );

        //check if form validation is success
        if ($this->form_validation->run()) {
            //set json response data
            $response['success'] = true;
            $response['page'] = base_url();

            //update user
            $this->user_model->updateUser($user_id, $user_data);

            //destroys current session
            session_destroy();

        } else {
            //set json response data
            $response['success'] = false;
            $response['errors'] = validation_errors();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Function to retrieve all user records
     *
     * @return void
     */
    public function getUsers()
    {

        //store getUsers function to a variable and execute
        $query = $this->user_model->getUsers()->result_array();

        //create an array variable
        $users = array();

        //iterate over query results
        foreach ($query as $row) {

            //create a temporary array variable
            $user = array();

            $user[] = $row['id'];
            $user[] = $row['firstname'];
            $user[] = $row['lastname'];
            $user[] = $row['username'];
            $user[] = $row['usertitle'];
            $users[] = $user;
        }
      return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $users)));
    }

    /**
     * Function to retrieve specific user record
     *
     * @param int $user_id
     * @return void
     */
    public function getOneRecord($user_id)
    {
        //store the getUser function to a variable and execute
        $query = $this->user_model->getUsers(array('id' => $user_id))->result();

        //iterate over query result
        foreach ($query as $row) {
               //push query result to user array
               $user[] = $row->firstname;
               $user[] = $row->lastname;
               $user[] = $row->username;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    /*
    *The following are only used in validation
    */
    public function _name_check($str)
    {
        if(empty($str)) {
            $this->form_validation->set_message('_name_check', 'The {field} is required');
            return false;
        }
        if (!preg_match('/^[a-z ]+$/i', $str)) {
            $this->form_validation->set_message('_name_check', 'The {field} must have letters and spaces only');
            return false;
        }
        return true;
    }



}
