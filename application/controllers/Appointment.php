<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('appointment_model');
		$this->load->library('sms');
    }

   /**
    * Function to cancel selected appointment
    *
    * @param int $appointment_id
    * @return void
    */
    public function cancelAppointment($appointment_id)
    {
        //mark appointment as cancelled
        $query = $this->appointment_model->cancelAppointments($appointment_id, 0);

        // verify if the query is successful
        if ($query) {
            $response['success'] = true;
        } else{
            $response['success'] = false;
        }
      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Function to create appointment
     *
     * @return void
     */
    public function createAppointment()
    {
        //server-side form validation
            $this->form_validation->set_rules('appointment_time', 'appointment time','required');
            $this->form_validation->set_rules('appointment_date', 'appointment date', 'required');
            $this->form_validation->set_rules('patient_id', 'patient name','required',array('required' => 'You must select a patient'));

        //store data in an array variable to be inserted to the database
            $appointment_data = array (
                'patient_id' => $this->input->post('patient_id'),
                'appointment_date' => $this->input->post('appointment_date'),
                'appointment_time' => $this->input->post('appointment_time'),
                'userID' => $this->input->post('user_id')
            );

        //check if form validation is success
            if ($this->form_validation->run()) {

                // check if appointment exist
                $createAppointment = $this->appointment_model->createAppointment($appointment_data);

                //execute this scope if appointment do not exist
                if ($createAppointment) {

                    //set json response data
                    $response['success'] = true;
                    $response['message'] = 'Successfully appointed patient';

										//sms schedule format
										$sendOn = new DateTime($appointment_data['appointment_date'] . $appointment_data['appointment_time']);
										$sendOn = $sendOn->sub(new DateInterval('P2D'));
										$date = date('l, F j, Y',strtotime($appointment_data['appointment_date']));
										$time = date('h:i a', strtotime($appointment_data['appointment_time']));

										//send sms to patient and doctor
										$this->sendToPatient($this->input->post('patient_id'),
																				 $date,
																				 $time,
																				 $sendOn->format('Y-m-d H:i'));
										$this->sendToDoctor($this->input->post('patient_id'),
																			  $date,
																				$time,
																				$sendOn->format('Y-m-d H:i'));


                    // //store data in an array variable to be inserted to pending SMS table
                    // $sms_data = array(
                    //     'appointment_id' => $this->db->insert_id(),
                    //     'patient_id'     => $this->input->post('patient_id'),
                    //     'sms_status'     => 0
                    // );
										//
                    // //insert records to pending SMS  table
                    // $this->appointment_model->createSMS($sms_data);

                } else {
                    //set json response data
                    $response['success'] = false;
                    $response['message'] = 'Appointment existed for that patient';
                }
            } else {
                //set json response data
                $response['success'] = false;
                $response['errors'] = $this->form_validation->error_array();
            }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Function to update the selected appointment
     *
     * @param int $appointment_id
     * @return void
     */
    public function updateAppointment($appointment_id)
    {
        //store data in an array variable to be inserted to the database
        $appointment_data = array(
            'appointment_date' => $this->input->post('appointment_date'),
            'appointment_time' => $this->input->post('appointment_time')
        );

        //store and execute appointment model updateAppointment function to a variable
        $query = $this->appointment_model->updateAppointment($appointment_id, $appointment_data);

        //check if query is successful
        if ($query) {
            //set json response data
            $response['message'] = 'Successfully change appointment date';
            $response['success'] = true;
        } else {
            //set json response data
            $response['success'] = false;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Function to retrieve all appointments
     *
     * @return void
     */
    public function calendarAppointments()
    {
        //store and execute appointment model calendarAppointments function to a variable
        $query = $this->appointment_model->calendarAppointments();

        //create an array variable
        $events = array();

        //iterate over query result
        foreach($query as $rows) {

            //create a temporary array variable
            $event = array();

            //store datetime object based on appointment date to a variable
            $date = new DateTime($rows['appointment_date']);

            //push data to event array
            $event['patient_id'] = $rows['id'];
            $event['title'] = $rows['patientName'];
            $event['start'] = $date->format('Y-m-d');

            //push the event to events array
            $events[] = $event;
        }
       return $this->output->set_content_type('application/json')->set_output(json_encode($events));
    }

    /**
     * Function to retrieve available appointment time slots
     *
     * @param date $appointment_date
     * @return void
     */
    public function getUnavailableTime($appointment_date)
    {
        //store and execute appointment model getUnavailableTime function to a variable
        $query = $this->appointment_model->getUnavailableTime($appointment_date);

        //create an array variable
        $timeslots = array();

        //iterate over query result
        foreach ($query as $times){

            //create a temporary array variable
            $timeslot = array();

            //store 24-hour, minutes with leading zero to a variable
            $start = date('H:i',strtotime($times->appointment_time));

            //add 30 minutes to appointment time and store to a variable
            $end = date('H:i', strtotime('+30minutes', strtotime($start)));

            //push data to timeslot array
            $timeslot[] = $start;
            $timeslot[] = $end;

            //push the timeslot to timeslots array
            $timeslots[] = $timeslot;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($timeslots));
    }

    /**
     * Function to get all appointments
     *
     * @return void
     */
    public function getCurrentAppointments()
    {
        //store and execute appointment model getAppointments function to a variable
        $query = $this->appointment_model->getCurrentAppointments();

        //create an array variable
        $appointments = array();

        //iterate over query result
        foreach ($query as $rows) {

            //create a temporary array variable
            $appointment = array();

            //push data to appointment array
            $appointment[] = $rows->id;
            $appointment[] = $rows->patient_id;
            $appointment[] = $rows->patientName . " - " . date('h:i a',strtotime($rows->appointment_time));

            //push appointment to appointments array
            $appointments[] = $appointment;
        }
       return $this->output->set_content_type('application/json')->set_output(json_encode($appointments));
    }

   /**
    * Function to retrieve 2 days before appointments
    *
    * @return void
    */
    public function getAllAppointments()
    {
        //store and execute appointment model upcomingAppointments function to a variable
        $query = $this->appointment_model->getAllAppointments();

        //create an array variable
        $appointments = array();

        //iterate over query result
            foreach($query as $rows) {

                //create a temporary variable
                $appointment = array();

                //push data to appointment array
                $appointment[] = $rows->id;
                $appointment[] = $rows->patient_id;
                $appointment[] = $rows->patientName;
                $appointment[] = $rows->appointment_date;
                $appointment[] = date('h:i a', strtotime($rows->appointment_time));
                $appointment[] = $rows->created_by;


                //push appointment to appointments array
                $appointments[] = $appointment;
            }
        return $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $appointments)));
    }

    /**
     * Function to disable dates in the date picker
     *
     * @param date $date
     * @return void
     */
    public function disabledDate($date, $user)
    {
        //call disabledDate function from appointment model
        $this->appointment_model->disabledDate($date, $user);
    }

    /**
     * Function to get disabled dates for fullcalendar
     *
     * @return void
     */
    public function getDisabledDates()
    {
       //store and execute appointment model getDisabledDates function to a variable
       $query = $this->appointment_model->getDisabledDates();

       //create an array variable
       $appointment_dates = array();

       //iterate over query result
       foreach ($query as $result) {

           //create a temporary variable
           $appointment_date = array();

           //push data to appointment_date array
           $appointment_date['start'] = $result->na_date;
           $appointment_date['title'] = 'Unavailable';

           //push appointment_date to appointment_dates array
           $appointment_dates[] = $appointment_date;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($appointment_dates));
    }

    public function upcomingAppointments()
    {
        $query = $this->appointment_model->upcomingAppointments();
        $appointments = array();

        foreach ($query as $row) {
            $appointment = array();
            $appointment['schedule'] = date('F d, Y',strtotime($row->appointment_date)) . ' - ' .  date('H:i a', strtotime($row->appointment_time));
            $appointment['patient']  = $row->patientName;
            $appointments[] = $appointment;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($appointments));
    }
		public function sms_notify()
		{
			$phone = $this->input->post('phone');
		}
		public function send_sms()
		{
			$phone = $this->input->post('phones');
			$message = $this->input->post('message');
			$dat = new DateTime();

			$dat = $dat->format('Y-m-d') . " " . date('H:i', strtotime('01:13'));
			$result = $this->sms->sendSMS($phone,$message, $dat);
		  $raw = strstr($result, 'MessageID=');
		  $tx = array_count_values(str_word_count($raw, 1));
		  echo json_encode($tx['MessageID']);
		}
	public function sendToDoctor($patient_id, $date, $time, $sendDate)
	{
		$doctor_id = $this->appointment_model->docId();
		$doctor = $this->appointment_model->sendCC($doctor_id[0]->id);
		$patient = $this->appointment_model->sendTo($patient_id);
		$patientName = ($patient[0]->gender === 'Male') ? 'Mr. ' : 'Ms. ';
		$patientName .= $patient[0]->lastname;
		$name = 'Dr. ' . $doctor[0]->lastname;
		$msg = "Good Day " . $name . ",\n\n";
		$msg .= "Please be reminded that you have an upcoming appointment to $patientName ";
		$msg .= "this $date at $time.\n\nThank You. \n\n\n";
		$msg .= "Note: This is a system-generated message. Please do not reply";
		$tx = $this->sms->sendSMS($doctor[0]->contact, $msg, $sendDate);

	}
	public function sendToPatient($patient_id, $date, $time, $sendDate)
		{
			 $patient = $this->appointment_model->sendTo($patient_id);
			 $gender = ($patient[0]->gender === 'Male') ? 'Mr. ' : 'Ms. ';
			 $sms = array(
				 "patient_contact" => $patient[0]->contact,
				 "patient_lastname" => $gender . $patient[0]->lastname,

			 );
			 $msg = "Good Day " . $gender . $patient[0]->lastname . ",\n\n";
			 $msg .= "This is from Aguilar Clinic. Please be reminded of your upcoming appointment ";
			 $msg .= "this $date at $time .\n\nThank You. \n\n\n";
			 $msg .= "Note: This is a system-generated message. Please do not reply";
			 $t = $this->sms->sendSMS($patient[0]->contact, $msg, $sendDate);
			 return $t;
		}



}
