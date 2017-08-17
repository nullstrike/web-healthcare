<?php

class Patient extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
   public function insertPatient()
   {
          //validation rules
          $this->form_validation->set_rules('firstname', 'first name', 'required|trim|callback__name_check');
          $this->form_validation->set_rules('middlename', 'middle name', 'trim|callback__mid_name');
          $this->form_validation->set_rules('lastname', 'last name', 'trim|required|callback__name_check');
          $this->form_validation->set_rules('gender', 'gender', 'required');
          $this->form_validation->set_rules('birthdate', 'birthdate', 'required');
          $this->form_validation->set_rules('height', 'height', 'callback__wh_check|required');
          $this->form_validation->set_rules('weight', 'weight', 'callback__wh_check|required');
          $this->form_validation->set_rules('bloodtype','Blood type', 'required');
          $this->form_validation->set_rules('address', 'address', 'required');
          $this->form_validation->set_rules('contact','contact number', 'numeric|required');

          //form data
          $data = array(
                   "patient_fname" => $this->input->post('firstname'),
                   "patient_mname" => $this->input->post('middlename'),
                   "patient_lname" => $this->input->post('lastname'),
                   "patient_age"   => $this->input->post('age'),
                   "patient_gender" => $this->input->post('gender'),
                   "patient_birthdate" => $this->input->post('birthdate'),
                   "patient_bloodtype" => $this->input->post('bloodtype'),
                   "patient_height" => $this->input->post('height'),
                   "patient_weight" => $this->input->post('weight'),
                   "patient_address" => $this->input->post('address'),
                   "patient_contact" => $this->input->post('contact')
          );

        if ($this->form_validation->run()) {
              $response['success'] = true;
              $response['message'] = "Successfully added patient information";
              $this->patient_model->insertPatient($data);
        } else {
              $response['errors'] = $this->form_validation->error_array();
              $response['success'] = false;
        }
      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
   }

   public function updatePatient()
   {    
        //validation rules
        $this->form_validation->set_rules('firstname', 'first name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('middlename', 'middle name', 'trim|callback__mid_name');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('birthdate', 'birthdate', 'required');
        $this->form_validation->set_rules('height', 'height', 'callback__wh_check|required');
        $this->form_validation->set_rules('weight', 'weight', 'callback__wh_check|required');
        $this->form_validation->set_rules('bloodtype','Blood type', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('contact','contact number', 'numeric|required');

        //form data
       $id = $this->input->post('patient_id');
       $data = array(
               "patient_fname" => $this->input->post('firstname'),
               "patient_mname" => $this->input->post('middlename'),
               "patient_lname" => $this->input->post('lastname'),
               "patient_age"   => $this->input->post('age'),
               "patient_gender" => $this->input->post('gender'),
               "patient_birthdate" => $this->input->post('birthdate'),
               "patient_bloodtype" => $this->input->post('bloodtype'),
               "patient_height" => $this->input->post('height'),
               "patient_weight" => $this->input->post('weight'),
               "patient_address" => $this->input->post('address'),
               "patient_contact" => $this->input->post('contact')
            );

        
        if ($this->form_validation->run()) {
              $response['success'] = true;
              $response['message'] = 'Successfully updated patient';
              $this->patient_model->updatePatient($id, $data);
        } else {
              $response['success'] = false;
              $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
   }

   public function patientOldData()
   {
      $data = array(
                 'patient_id' => $this->input->post('id'),
                 'patient_height' => $this->input->post('old_height'),
                 'patient_weight' => $this->input->post('old_weight')
        );
      $this->patient_model->patient_oldData($data);
      return;
   }

   public function getPatient()
   {
      
    $id = $this->input->post('patient_id');
    $query = $this->patient_model->patientList(array('patient_id' => $id));
      foreach($query as $row) {
          $result = array();
          $result['patient_id'] = $row->patient_id;
          $result['patient_fname'] = $row->patient_fname;
          $result['patient_mname'] = $row->patient_mname;
          $result['patient_lname'] = $row->patient_lname;
          $result['patient_bdate'] = $row->patient_birthdate;
          $result['patient_age'] = $row->patient_age;
          $result['patient_gender'] = $row->patient_gender;
          $result['patient_bloodtype'] = $row->patient_bloodtype;
          $result['patient_height'] = $row->patient_height;
          $result['patient_weight'] = $row->patient_weight;
          $result['patient_address'] = $row->patient_address;
          $result['patient_contact'] = $row->patient_contact;
      }
    return $this->output->set_content_type('application/json')->set_output(json_encode($result)); 
   }
   public function patientList()
   {
        $data = array();
        $rows = $this->patient_model->patientList();
        foreach ($rows as $row) {
           $result = array();
           $result[] = $row->patient_id;
           $result[] = $row->patient_fname;
           $result[] = $row->patient_mname;
           $result[] = $row->patient_lname;
           $result[] = '<button id="fetchPatient" class="btn-flat btn-small waves-effect waves-light"><i class="material-icons blue-text md-36">edit</i></button>'
                       . '<button id="consultPatient" class="btn-flat btn-small"><i class="material-icons orange-text md-36">assignment</i></button>';
         
           $data[] = $result;
       }
       return $this->output->set_content_type('application/json')->set_output(json_encode(array("data" => $data)));
   }

  public function _wh_check($str)
  {
      if (!preg_match('/^\d{2,3}\.?\d*$/', $str)) {
        $this->form_validation->set_message('_wh_check','The {field} must only contain numbers and decimal');
        return false;
      } 
      return true;  
  }
  public function _name_check($str)
  {
      if (!preg_match('/^[a-z ]+$/i', $str)) {
          $this->form_validation->set_message('_name_check', 'The {field} field must have letters and spaces only');
          return false;
      }
      return true;
  }
   public function _mid_name($str){
      if (empty($str)){
          return true;
      }else{
          if (!preg_match('/^[a-z ]+$/i', $str)) {
              $this->form_validation->set_message('_mid_name', 'The {field} field must have letters and spaces only');
              return false;
          }
          return true;
      }
   }
   public function addConsultation(){
      $data = array(
          'patient_id' => $this->input->post('patient_id'),
          'diagnosis' => $this->input->post('diagnosis'),
          'prescription'=> $this->input->post('prescription')
        );

      $this->patient_model->addConsultation($data);
   }
}
