<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('consultation_model');
    }

    /**
     * Function to create consultation
     *
     * @param  int $appointment_id
     * @return void
     */
    public function createConsultation($appointment_id)
    {
        //server-side form validation
        $this->form_validation->set_rules('diagnosis', 'diagnosis', 'required');
        $this->form_validation->set_rules('medication', 'medication', 'required');
        $this->form_validation->set_rules('weight', 'weight', 'required|callback__wh_check');
        $this->form_validation->set_rules('height', 'height', 'required|callback__wh_check');

            //check if form validation is success
            if ($this->form_validation->run()) {

                //store data in an array variable to be inserted to the database
                $consultation_data = array (
                    'patient_id' => $this->input->post('patient_id'),
                    'date' => $this->input->post('consultation_date'),
                    'diagnosis' => $this->input->post('diagnosis'),
                    'medication' => $this->input->post('medication'),
                    'note' => $this->input->post('note'),
                    'height' => $this->input->post('height'),
                    'weight' => $this->input->post('weight'),
                    'type' => $this->input->post('type')
                );

                //store and execute consultation model createConsultation function to a variable
                $query = $this->consultation_model->createConsultation($consultation_data);

                //check if consultation type is appointment
                if ($query && $consultation_data['type'] === 'appointment'){
                    //mark appointment status as complete
                    $this->consultation_model->completeAppointment($appointment_id);
                }

                //set json response data
                $response['id'] = $this->db->insert_id();
                $response['success'] = true;
                $response['message'] = 'Successfully saved consultation data';

            } else {

                //set json response data
                $response['success'] = false;
                $response['errors'] = $this->form_validation->error_array();

            }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    /**
     * Function to retrieve consultation log based on patient id
     *
     * @param  int $patient_id
     * @return void
     */
    public function getConsultationbyID()
    {
        //grab search query
        $patient_id = $this->input->post('patient_id');
        //store and execute consultation model createConsultation function to a variable
        $query = $this->consultation_model->getConsultation($patient_id);

        //create an array variable
        $consultation_logs = array();

        //iterate over query result
        foreach ($query as $rows) {
            //create a temporary array variable
            $consultation_log = array();

            //push data to consultation_log array
            $consultation_log[] = $rows->date;
            $consultation_log[] = $rows->diagnosis;
            $consultation_log[] = $rows->medication;
            $consultation_log[] = $rows->note;

            //push consultation_log to consultation_logs array
            $consultation_logs[] = $consultation_log;
        }

        //return a json encoded data
        return  $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$consultation_logs)));
    }

    /**
     * Function to retrieve consultation log based on patient id, and date
     *
     * @param int $patient_id
     * @param date $start_date
     * @param date $end_date
     * @return void
     */
    public function getConsultationbyDate($patient_id, $start_date, $end_date)
    {
      //store and execute consultation model getConsultationbyDate function to a variable
      $query = $this->consultation_model->getConsultationbyDate($patient_id, $start_date, $end_date);

      //create an array variable
      $consultation_logs = array();

      //iterate over query result
      foreach ($query as $rows) {
          //create a temporary variable
          $consultation_log = array();

          //push data to consultation log array
          $consultation_log[] = $rows['id'];
          $consultation_log[] = $rows['date'];
          $consultation_log[] = $rows['medication'];
          $consultation_log[] = $rows['diagnosis'];

          //push consultation log to consultation logs array
          $consultation_logs[] = $consultation_log;

        }
        //return a json encoded data
        return $this->output->set_content_type('application/json')->set_output(json_encode(array("data" =>$consultation_logs)));
    }

    /**
     * Function to insert payment data to payment table
     *
     * @return void
     */
    public function createPayment()
    {
        //store data in an array variable to be inserted to the database
        $payment_data = array (
            'consultation_id' => $this->input->post('consultation_id'),
            'payment_given' => $this->input->post('payment_given'),
            'payment_amount' => $this->input->post('payment_amount'),
            'payment_date'   => $this->input->post('payment_date')
        );

        $this->form_validation->set_rules('payment_given', 'payment given', 'required');
        $this->form_validation->set_rules('payment_amount', 'payment_amount', 'required');

        if ($this->form_validation->run() === FALSE) {
          $response['errors'] = $this->form_validation->error_array();
          $response['success'] = false;
        }
        else {
          //execute createPayment function
          $this->consultation_model->createPayment($payment_data);
          $response['success'] = true;

        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
      }
    /**
     * Function to retrieve all patient reports
     *
     * @return void
     */
    public function getReports()
    {
       //store and execute consultation model getReports function to a variable
       $query = $this->consultation_model->getReports();

       //create an array variable
       $reports = array();

       //iterate over query result
       foreach ($query as $rows) {

            //create a temporary array variable
            $report   = array();

            //convert consultation date to a DateTime object
            $date  = new DateTime($rows->date);

            //push data to report array
            $report[] = $rows->id;
            $report[] = $rows->patientName;
            $report[] = $date->format('m-d-Y');
            $reports[] = $report;

        }

       //return a json encoded data
       return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $reports)));
    }

    /**
     * Function to retrieve diagnosis data based on consultation id
     *
     * @param int $id
     * @return void
     */
    public function getDiagnosis($consultation_id)
    {
       //store and execute consultation model getDiagnosis function to a variable
       $query = $this->consultation_model->getDiagnosis($consultation_id);

       //return a json encoded data
       return $this->output->set_content_type('application/json')->set_output(json_encode($query));
    }

    /**
     * Function to retrieve prescription data based on consultation id
     *
     * @param int $id
     * @return void
     */
    public function getPrescription($consultation_id)
    {
        //store and execute consultation model getPrescription function to a variable
        $query = $this->consultation_model->getPrescription($consultation_id);

        //return a json encoded data
        return $this->output->set_content_type('application/json')->set_output(json_encode($query));
    }

    /**
     * Function to retrieve payment details based on consultation id
     *
     * @param int $consultation_id
     * @return void
     */
    public function getReceipt($consultation_id)
    {
        //store and execute consultation model getReceipt function to a variable
        $query = $this->consultation_model->getReceipt($consultation_id);

        //return a json encoded data
        return $this->output->set_content_type('application/json')->set_output(json_encode($query));
    }

    /**
     * A callback function to check if the input is a valid weight value
     *
     * @param string $str
     * @return void
     */
   public function _wh_check($str)
   {
       //check if an input contains letters
       if (!preg_match('/^\d{2,3}\.?\d*$/', $str)) {
         $this->form_validation->set_message('_wh_check','The {field} must contain numbers and decimal');
         return false;
       }
       return true;
   }
}
