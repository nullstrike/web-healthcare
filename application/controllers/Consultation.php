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
    public function viewConsultation()
    {

    }
    public function test(){
        $data = array('patient_id'=> 1, 'consultation_date' => '2017-09-09', 'prescription' => 'blah', 'diagnosis' => 'blah');
        $query = $this->consultation_model->test($data);
        echo $query;
    }
}


