<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('appointment_model');
		$this->load->library('form_validation');
    }
    
    public function getAppointments()
    {
        $query = $this->appointment_model->getAppointments();
        $result = array();
        foreach($query as $rows){
            $row = array();
            $row[] = $rows['appointment_date'];
            $row[] = $rows['patient_name'];
            $row[] = $rows['created_by'];
            $row[] = '<button class="ui button mini icon">asd</button>';
            $result[] = $row;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result)));
    }
   
    public function cancelAppointment()
    {
        $id = $this->input->post('appointment_id');
        $status = 0;
        $query = $this->appointment_model->cancelAppointments($id, $status);
        if ($query){
            $response['success'] = true;
           
        } else{
            $response['success'] = false;
            //$response['message'] = 'Appoinment has been cancelled';
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function createEvent()
    {
            $this->form_validation->set_rules('appointment_time', 'appointment time','required');
            $this->form_validation->set_rules('appointment_date', 'appointment date', 'required');
            $this->form_validation->set_rules('patient_id', 'patient name','required',array('required' => 'You must select a patient'));
           
            $appointment_data = array (
                'patient_id' => $this->input->post('patient_id'),
                'appointment_date' => $this->input->post('appointment_date'),
                'appointment_time' => $this->input->post('appointment_time'),
                'userID' => $this->input->post('user_id')
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
    public function updateEvent()
    {
        $id = $this->input->post('appointment_id');
        $data = array(
            'appointment_date' => $this->input->post('appointment_date'),
            'appointment_time' => $this->input->post('appointment_time')
        );
        $query = $this->appointment_model->updateEvent($id, $data);
        if ($query) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
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
                $event['title'] = $rows['patientName'];
                $event['start'] = $date->format('Y-m-d');
                $events[] = $event;
            }
       return $this->output->set_content_type('application/json')->set_output(json_encode($events));
    }
    public function send_sms($date, $id)
    {

    }

    public function getAvailableTime()
    {
        $date = $this->input->get('appointment_date');
        $query = $this->appointment_model->getAvailableTime($date);
        $slot = array();
        foreach ($query as $times){
            $time = array();
            $start = date('H:i',strtotime($times->appointment_time)); 
            $end = strtotime('+30minutes', strtotime($start));
            $end = date('H:i', $end);
            $time[] = $start;
            $time[] = $end;
            $slot[] = $time;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($slot));
    }

   public function getAppointmentsToday()
   {
       $query = $this->appointment_model->getAppointmentsToday();
       $result = array();
       foreach ($query as $rows){
           $row = array();
           $time = $rows->appointment_time;
           $row[] = $rows->id;
           $row[] = $rows->patient_id;
           $row[] = $rows->patientName . " - " . date('h:i a',strtotime($time));
           $result[] = $row;
        }
       return $this->output->set_content_type('application/json')->set_output(json_encode($result));
   }
    public function upcomingEvents()
    {
            $query = $this->appointment_model->upcomingEvents();
            $events = array();
            foreach($query as $rows){
                    $row = array();
                    $time = $rows->appointment_time;
                    $row[] = $rows->id;
                    $row[] = $rows->patient_id;
                    $row[] = $rows->patientName;
                    $row[] = $rows->appointment_date;
                    $row[] = date('h:ia', strtotime($time));
                    $row[] = $rows->created_by;
                    $row[] = '<button class="ui icon mini orange button update"><i class="repeat icon"></i>Reschedule</button>&nbsp;<button class="ui icon mini red button remove"><i class="delete calendar icon"></i>Cancel Appointment</button>';

                    $events[] = $row;
            }
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $events)));
    }
    public function disabledDate()
    {
        $data = array(
                'na_date' => $this->input->post('na_date')
            );
        $this->appointment_model->disabledDate($data);
        return;        
    }

    public function fetchdisabledDates()
    {
       $query = $this->appointment_model->fetchdisabledDates();
       $dates = array();
       foreach ($query as $result){
           $date = array();
           $date['start'] = $result->na_date;
           $date['title'] = 'Unavailable';
           $dates[] = $date;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($dates));
    }

    



}
