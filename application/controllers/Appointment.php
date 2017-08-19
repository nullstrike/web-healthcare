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
    
    public function getPatientName()
    {
            $rows = $this->appointment_model->fetchPatientName();
            $name = array();
            foreach ($rows as $row) {
                $name[$row->patientName] = $row->patient_id;
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
                $date = new DateTime($rows['appointment_date']);
                $event['patient_id'] = $rows['patient_id'];
                $event['title'] = 'Appointment for '.$rows['patientName'];
                $event['start'] = $date->format('Y-m-d');
                $events[] = $event;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($events));
    }
    public function send_sms($date, $id)
    {
        
    }
   
}
