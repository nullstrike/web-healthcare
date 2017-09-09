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
                   "firstname" => $this->input->post('firstname'),
                   "middlename" => $this->input->post('middlename'),
                   "lastname" => $this->input->post('lastname'),
                   "age"   => $this->input->post('age'),
                   "gender" => $this->input->post('gender'),
                   "birthdate" => $this->input->post('birthdate'),
                   "bloodtype" => $this->input->post('bloodtype'),
                   "height" => $this->input->post('height'),
                   "weight" => $this->input->post('weight'),
                   "address" => $this->input->post('address'),
                   "contact" => $this->input->post('contact')
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
       $id = $this->input->post('id');
       $data = array(
                "firstname" => $this->input->post('firstname'),
                "middlename" => $this->input->post('middlename'),
                "lastname" => $this->input->post('lastname'),
                "age"   => $this->input->post('age'),
                "gender" => $this->input->post('gender'),
                "birthdate" => $this->input->post('birthdate'),
                "bloodtype" => $this->input->post('bloodtype'),
                "height" => $this->input->post('height'),
                "weight" => $this->input->post('weight'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact')
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
    $id = $this->input->post('id');
    $query = $this->patient_model->patientList(array('id' => $id));
      foreach($query as $row) {
          $result = array();
          $result['id'] = $row->id;
          $result['firstname'] = $row->firstname;
          $result['middlename'] = $row->middlename;
          $result['lastname'] = $row->lastname;
          $result['birthdate'] = $row->birthdate;
          $result['age'] = $row->age;
          $result['gender'] = $row->gender;
          $result['bloodtype'] = $row->bloodtype;
          $result['height'] = $row->height;
          $result['weight'] = $row->weight;
          $result['address'] = $row->address;
          $result['contact'] = $row->contact;
      }
    return $this->output->set_content_type('application/json')->set_output(json_encode($result));
   }
   public function patientList()
   {
        $data = array();
        $rows = $this->patient_model->patientList();
        foreach ($rows as $row) {
           $result = array();
           $result[] = $row->id;
           $result[] = $row->firstname;
           $result[] = $row->middlename;
           $result[] = $row->lastname;
           $result[] = '<button class="ui mini icon button orange update"><i class="edit icon"></i>Edit</button><button class="ui mini icon button teal view"><i class="ellipsis vertical
           icon"></i>View More</button>';

           $data[] = $result;
       }
       return $this->output->set_content_type('application/json')->set_output(json_encode(array("data" => $data)));
   }

 

   public function getPatientName() 
   {
       $name = $this->input->get('q');
       if (! empty($name)){
        $query = $this->patient_model->fetchPatientName($name);
        $result = array();
        foreach($query as $rows){
            $row = array();
            $row['id'] = $rows->id;
            $row['text'] = $rows->name . "- Patient ID:" . $rows->id;
            $result[] = $row;
        }
       } else{
           return;
       }
      
       return $this->output->set_content_type('application/json')->set_output(json_encode($result));
   }

  public function _wh_check($str)
  {
      if (!preg_match('/^\d{2,3}\.?\d*$/', $str)) {
        $this->form_validation->set_message('_wh_check','The {field} must contain numbers and decimal');
        return false;
      }
      return true;
  }
  public function _name_check($str)
  {
      if (!preg_match('/^[a-z ]+$/i', $str)) {
          $this->form_validation->set_message('_name_check', 'The {field} must have letters and spaces');
          return false;
      }
      return true;
  }
   public function _mid_name($str){
      if (empty($str)){
          return true;
      }else{
          if (!preg_match('/^[a-z ]+$/i', $str)) {
              $this->form_validation->set_message('_mid_name', 'The {field} must have letters and spaces');
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

   public function getQuarters()
   {
     $query = $this->patient_model->patientStats();
      if (isset($query)){
        $result[] = $query->firstQuarter;
        $result[] = $query->secondQuarter;
        $result[] = $query->thirdQuarter;
        $result[] = $query->fourthQuarter;
      }
      return $this->output->set_content_type('application/json')->set_output(json_encode($result));
   }


}
