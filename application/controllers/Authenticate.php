<?php

/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/5/17
 * Time: 2:47 PM
 */
class Authenticate extends CI_Controller{

    public function index(){
        $this->load->view('header');
        $this->load->view('authenticate_view');
        $this->load->view('footer');
    }

}