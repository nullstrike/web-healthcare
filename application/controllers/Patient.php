<?php

class Patient extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');

    }

   /**
    * Function to create patient record
    *
    * @return void
    */
   public function createPatient()
   {
        //server-side form validation
        $this->form_validation->set_rules('firstname', 'first name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('middlename', 'middle name', 'trim|callback__mid_name');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('birthdate', 'birthdate', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('contact','contact number', 'numeric|required|exact_length[11]');

        //store data in an array variable to be inserted to the database
          $patient_data = array(
                "firstname" => $this->input->post('firstname'),
                "middlename" => $this->input->post('middlename'),
                "lastname" => $this->input->post('lastname'),
                "age"   => $this->input->post('age'),
                "gender" => $this->input->post('gender'),
                "birthdate" => $this->input->post('birthdate'),
                "bloodtype" => $this->input->post('bloodtype'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact')
        );

        //check if form validation is success
        if ($this->form_validation->run()) {

              //set json reponse data
              $response['success'] = true;
              $response['message'] = "Successfully added patient information";

              //call createPatient function from patient model
              $response['id'] = $this->patient_model->createPatient($patient_data);
        } else {

              //set json response data
              $response['errors'] = $this->form_validation->error_array();
              $response['success'] = false;
        }

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
   }

   /**
    * Function to update patient data based on patient id
    *
    * @param int $patient_id
    * @return void
    */
   public function updatePatient($patient_id)
   {
        //server-side form validation
        $this->form_validation->set_rules('firstname', 'first name', 'required|trim|callback__name_check');
        $this->form_validation->set_rules('middlename', 'middle name', 'trim|callback__mid_name');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required|callback__name_check');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('birthdate', 'birthdate', 'required');
        $this->form_validation->set_rules('bloodtype','Blood type', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('contact','contact number', 'numeric|required|exact_length[11]');

       //store data in an array variable to be inserted to the database
       $patient_data = array(
                "firstname" => $this->input->post('firstname'),
                "middlename" => $this->input->post('middlename'),
                "lastname" => $this->input->post('lastname'),
                "age"   => $this->input->post('age'),
                "gender" => $this->input->post('gender'),
                "birthdate" => $this->input->post('birthdate'),
                "bloodtype" => $this->input->post('bloodtype'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact')
       );

       //check if form validation is success
        if ($this->form_validation->run()) {

              //set json response data
              $response['success'] = true;
              $response['message'] = 'Successfully updated patient';

              //call updatePatient function from patient model
              $this->patient_model->updatePatient($patient_id, $patient_data);
        } else {

              //set json response data
              $response['success'] = false;
              $response['errors'] = $this->form_validation->error_array();
        }

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
   }


   /**
    * Function to retrieve patient based on patient id
    *
    * @param int $patient_id
    * @return void
    */
   public function getPatient($patient_id)
   {
      //store and execute patient model patientList function to a variable
      $query = $this->patient_model->patientList(array('id' => $patient_id), FALSE);

      //iterate over query result
      foreach($query as $row) {

          //create an array variable to store the patient data
          $patient_data = array();

          //push patient data to the array
          $patient_data['id'] = $row->id;
          $patient_data['firstname'] = $row->firstname;
          $patient_data['middlename'] = $row->middlename;
          $patient_data['lastname'] = $row->lastname;
          $patient_data['birthdate'] = $row->birthdate;
          $patient_data['age'] = $row->age;
          $patient_data['gender'] = $row->gender;
          $patient_data['bloodtype'] = $row->bloodtype;
          $patient_data['address'] = $row->address;
          $patient_data['contact'] = $row->contact;
      }
     return $this->output->set_content_type('application/json')->set_output(json_encode($patient_data));
   }

   /**
    * Function to retrieve all patient
    *
    * @return void
    */
    public function t()
    {
      echo $this->patient_model->patientList();
    }
   public function getPatientList()
   {
        //store and execute patient model patientList function to a variable
        $query = $this->patient_model->patientList();
        //create an array variable
        $patients = array();

        //iterate over query result
        foreach ($query as $row) {
          $wh = $this->patient_model->retrieveWH($row->id);

           //create a temporary variable
           $patient = array();

           //push data to patient array
           $patient['id'] = $row->id;
           $patient['firstname'] = $row->firstname;
           $patient['middlename'] = $row->middlename;
           $patient['lastname'] = $row->lastname;
           $patient['gender'] = $row->gender;
           $patient['birthdate'] = $row->birthdate;
           $patient['age'] = $row->age;
           $patient['bloodtype'] = $row->bloodtype;
           $patient['address'] = $row->address;
           $patient['contact'] = $row->contact;

           //appending Weight / height
            for ($i=0; $i < count($wh) ; $i++) {
              $patient['weight'] = (empty($wh[$i]->weight)) ? 'Not available' : $wh[$i]->weight . ' kg';
              $patient['height'] = (! isset($wh[$i]->height)) ? 'Not available' : $wh[$i]->height . ' cm';
            }

           //setting default data for null values
          //   $patient['height'] = ($patient['height'] === null) ? 'Not available' : $patient['height'] . ' cm';
            //$patient['weight'] = ($patient['weight'] === null) ? 'Not available' : $patient['weight']  . ' kg';
           //push patient to patients array
           $patients[] = $patient;
       }
       return $this->output->set_content_type('application/json')->set_output(json_encode(array("data" => $patients)));
   }


   /**
    * Function to retrieve Patient Name (uses on select2 plugin)
    *
    * @return void
    */
   public function getPatientName()
   {
       //store get value to a variable
       $name_search = $this->input->get('q');

       //create an array variable
       $names = array();

       //check if name variable is empty
       if (! empty($name_search)){

         //store and execute patient model getPatientName function to a variable
         $query = $this->patient_model->getPatientName($name_search);

         //iterate over query result
         foreach($query as $row){
            //create a temporary variable
            $name = array();

            //push data to name array
            $name['id'] = $row->id;
            $name['text'] = $row->name . "- Patient ID:" . $row->id;

            //push name to names array
            $names[] = $name;
        }

      }
     return $this->output->set_content_type('application/json')->set_output(json_encode($names));
   }


   /**
    * Function to retrieve clinic statistics
    *
    * @return void
    */
   public function getClinicStats()
   {

       //store the data in an array
       $statistics = array(
            'walk_in'         => $this->patient_model->patientVisitType()->Walk_In,
            'appointment'     => $this->patient_model->patientVisitType()->Appointment,
            'totalPatient'    => $this->patient_model->patientNum(),
            'weekVisits'      => $this->patient_model->patientWeeklyStat()->WeekVisits,
            'quarterlyVisits' => $this->getClinicQuarters()
        );

        //return a json encoded data
        return $this->output->set_content_type('application/json')->set_output(json_encode($statistics));
   }

   /**
    * Function to retrieve quarterly patient visits of the clinic
    */
    public function getClinicQuarters()
    {
      //store and execute patient model patientList function to a variable
      $query = $this->patient_model->patientQuarterStat();

      //check if query is empty
       if (isset($query)){

         //push query data to an array
         $quarters[] = $query->firstQuarter;
         $quarters[] = $query->secondQuarter;
         $quarters[] = $query->thirdQuarter;
         $quarters[] = $query->fourthQuarter;
       }

       //return the array variable
       return $quarters;

    }


   /**
    * Custom form validation
    * uses regular expressions
    * ^ = Matches the beginning of the string
    * \d = Matches any digit character (0-9).
    * [a-z] = Matches a character between a to z
    * {2, 3} = Match between 2 and 3 of the preceding token.
    * \. = Matches a "." character (char code 46).
    * ? = Match between 0 and 1 of the preceding token.
    * * = Match 0 or more of the preceding token.
    * $ = Matches the end of the string
    * /i = case insensitive
    */





  /**
   * A callback function to check if the input is a valid name value
   *
   * @param string $str
   * @return void
   */
  public function _name_check($str)
  {
      //check if an input contains letters and spaces
      if (!preg_match('/^[a-z ]+$/i', $str)) {
          $this->form_validation->set_message('_name_check', 'The {field} must have letters and spaces');
          return false;
      }
      return true;
  }

  /**
   * A callback function to check if the input is a valid name (optional)
   *
   * @param string $str
   * @return void
   */
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




}
