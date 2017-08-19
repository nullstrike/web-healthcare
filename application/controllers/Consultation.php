<?php

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
        $this->form_validation->set_rules('prescription', 'prescription', 'required');

        if ($this->form_validation->run()) {
            $data = array (
                'patient_id' => $this->input->post('patient_id'),
                'consultation_date' => $this->input->post('consultation_date'),
                'diagnosis' => $this->input->post('diagnosis'),
                'prescription' => $this->input->post('prescription')
            );
            $query = $this->consultation_model->insertConsultation($data);
            if ($query) {
                $response['success'] = true;
                $response['message'] = 'Successfully saved consultation data';
            } else {
                $response['success'] = false;
                $response['errors'] = 'Unable to saved consultation data';
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $this->form_validation->error_array();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getlogbyID()
    {
        $patient_id = $this->input->post('patient_id');
        $result = array();
        $query = $this->consultation_model->getConsultation($patient_id);
 
            foreach ($query as $rows) {
                $row = array();
                $row[] = $rows['consultation_id'];
                $row[] = $rows['patient_id'];
                $row[] = $rows['consultation_date'];
                $row[] = $rows['prescription'];
                $row[] = $rows['diagnosis'];
                $result[] = $row;
            }

        $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$result)));
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
                $row[] = $rows['consultation_id'];
                $row[] = $rows['patient_id'];
                $row[] = $rows['consultation_date'];
                $row[] = $rows['prescription'];
                $row[] = $rows['diagnosis'];
                $result[] = $row;
            }
        $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$result)));
       /*  $start = $this->input->post('start_date');
        $end = $this->input->post('end_date');
        if  */
    }
    public function getDate()
    {
        $start = date('Y-m-d',strtotime('2017-08-15'));
        $end =  '';
        if ($start >= $end && $end == '') {
            $query = $this->consultation_model->getConsultationbyDate($start, $end);
            echo "<pre>";
            print_r($query);
        }
       /*  if ($end < $start){
            echo "test";
        } else {
            $query = $this->consultation_model->getConsultationbyDate($start, $end);
            echo "<pre>";
            print_r($query);
        } */
      /*   $query = $this->consultation_model->getConsultationbyDate($start, $end);
        echo "<pre>";
        print_r($query); */
    }

}


