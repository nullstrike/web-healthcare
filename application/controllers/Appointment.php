<?php 

/**
* 
*/
class Appointment extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('appointment_model');
		$this->load->library('form_validation');
	}
/*	public function appoint_validates(){
       $rules = array($this->validation_rules('patient_id','patient id', 'required'),
                      $this->validation_rules('appointment_date','appointment date','required'),
                      $this->validation_rules('appointment_time','appointment time', 'required')
       );
       return $rules;
    }
   public function createAppointment(){
   		$this->form_validation->set_rules('patient_id', 'patient id', 'required');
   		$this->form_validation->set_rules('appointment_date', 'appointment date', 'required');
   		$this->form_validation->set_rules('appointment_time', 'appointment')

       $data = array(
         "user_id"  => $this->input->post('user_id'),
         "patient_id" => $this->input->post('patient_id'),
         "appointment_date" => $this->input->post('appointment_date'),
         "appointment_time" => $this->input->post('appointment_time'),
       );
       $this->form_validation->set_rules($this->appoint_validates());
       if($this->form_validation->run()){
           $response['status'] = true;
           $this->patient_model->appointment($data);
       }else{
           $error = array();
           foreach($this->input->post() as $key => $val){
               $error[$key] = form_error($key);
           }
           $response['errors'] = array_filter($error);
           $response['status'] = false;
       }
       $this->jsonresponse($response);
   }
 public function events(){

    }
   public function fetch_name(){
       $name = array();
       $id = $this->input->post('id');
       if($rows = $this->patient_model->test($id)){
           $response['message'] = "success";
           $response['status'] = true;

           foreach($rows as $row){
              array_push($name,array(
                  $row['patient_fname'],
                  $row['patient_mname'],
                  $row['patient_lname']
              ));
              $response['name'] = $name;
           }
       }else{
           $response['status'] = false;
           $response['message'] = "failed";
       }

        $this->jsonresponse($response);
   }
   
   public function tests(){
       $rows = $this->patient_model->view_appointment();
       $data = array();
       foreach ($rows as $row){
          $result = array();
          $result['title'] = "Appointment for: " . $row['patient_lname'] . ", ". $row['patient_fname'];
          $result['start'] = date("Y-m-d H:i:s",strtotime($row['appointment_date'] . " " . $row['appointment_time']));
          $result['end'] = $row['appointment_date'];
          $data[] = $result;
       }
       $this->jsonresponse($data);
   }
*/
   public function getPatientName()
   {
	   	$rows = $this->appointment_model->fetchPatientName();
	   	$name = array();
	   	foreach ($rows as $row) {
	   		//$name['id'] = $row->patient_id;
	   		//$name['id'] = $row->patient_id;
	   		$name[$row->patientName] = $row->patient_id;
	   		//$name[] = $row->patientName;
	   			
	   	}
   		$this->output->set_content_type('application/json')->set_output(json_encode($name));
   }

   public function createEvent()
   {
   		$this->form_validation->set_rules('appointment_date', 'appointment date', 'required');
        $this->form_validation->set_rules('patient_id', 'patient name','required',array('required' => 'You must select a patient'));

        $appointment_data = array (
            'patient_id' => $this->input->post('patient_id'),
            'appointment_date' => $this->input->post('appointment_date')
        );
        if ($this->form_validation->run()) {
            $createAppointment = $this->appointment_model->createEvent($appointment_data);
            if ($createAppointment) {
                $response['success'] = true;
                $response['message'] = 'Successfully appointed patient';
            } else {
                $response['success'] = false;
                $response['message'] = 'Appointment existed for that patient';
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
   }

   public function fetchEvents()
   {
        $query = $this->appointment_model->fetchEvents();
        $events = array();
        foreach($query as $rows){
            $event = array();
            $start = new DateTime($rows['appointment_date']);
            $event['title'] = 'Appointment for '.$rows['patientName'];
            $event['start'] = $start->format('Y-m-d');
            $events[] = $event;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($events));
   }
   
}
