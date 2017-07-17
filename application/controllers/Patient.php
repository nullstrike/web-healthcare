<?php

class Patient extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
    }

    public function index(){
        $this->load->view('inc/header');
        $this->load->view('authenticate_view');
        $this->load->view('inc/footer');
    }
   public function add(){
       $data = array(
           "patient_fname" => $this->input->post('firstname'),
           "patient_mname" => $this->input->post('middlename'),
       );
       $this->patient_model->add_patient('patient',$data);
       echo json_encode("success");
   }

   public function view(){
       $data= array();
       $rows = $this->patient_model->view_patient();
      foreach($rows as $row){
          array_push($data,$row['patient_fname'],
                           $row['patient_mname']);
      }

   }

}