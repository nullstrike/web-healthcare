<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultation extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('consultation_model');
     
    }
    public function insertConsultation()
    {
        $this->form_validation->set_rules('diagnosis', 'diagnosis', 'required');
        $this->form_validation->set_rules('medication', 'medication', 'required');
        $this->form_validation->set_rules('findings', 'findings', 'required');
        $appointment_id = $this->input->post('appointment_id');
        if ($this->form_validation->run()) {
            $data = array (
                'patient_id' => $this->input->post('patient_id'),
                'consultation_date' => $this->input->post('consultation_date'),
                'diagnosis' => $this->input->post('diagnosis'),
                'medication' => $this->input->post('medication'),
                'findings' => $this->input->post('findings'),
                'note' => $this->input->post('note'),
                'type' => $this->input->post('type')
            );
          $this->consultation_model->insertConsultation($data);
          if ($data['type'] === 'appointment'){
              $this->consultation_model->completeAppointment($appointment_id);
          }
          $response['success'] = true;
          $response['message'] = 'Successfully saved consultation data';
  
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
     return  $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getlogbyID()
    {
        $patient_id = $this->input->post('patient_id');
        $result = array();
        $query = $this->consultation_model->getConsultation($patient_id);
 
            foreach ($query as $rows) {
                $row = array();
                $row[] = $rows->consultation_date;
                $row[] = $rows->diagnosis;
                $row[] = $rows->findings;
                $row[] = $rows->medication;
                $row[] = $rows->note;
                $result[] = $row;
            }
       return  $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$result)));
    }
    public function getlogbyDate()
    {
        $start = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end = date('Y-m-d', strtotime($this->input->post('end_date')));
        $patient_id = $this->input->post('patient_id');
            $query = $this->consultation_model->getConsultationbyDate($patient_id, $start, $end);
            $result = array();
            foreach ($query as $rows) {
                $row = array();
   /*              $row[] = $rows['consultation_id'];
                $row[] = $rows['patient_id']; */
                $row[] = $rows['consultation_date'];
                $row[] = $rows['prescription'];
                $row[] = $rows['diagnosis'];
                $result[] = $row;
            }
       return $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$result)));
    }

    public function Payment()
    {
        $data = array (
            'patient_id' => $this->input->post('patient_id'),
            'payment_date' => $this->input->post('payment_date'),
            'payment_given' => $this->input->post('payment_given'),
            'payment_amount' => $this->input->post('payment_amount')
        );

        $this->consultation_model->Payment($data);
        return;
    }
}


