<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment_model extends CI_Model
{
	private $_user = 'user';
	private $_patient = 'patient';
	private $_app = 'appointment';
	private $_doc = 'doctor_schedule';
	private $_sms = 'sms';

	public function __construct()
	{
		parent::__construct();
	}

	public function createAppointment($data)
	{
			$this->db->insert($this->_app, $data);
			return true;
	}
	public function updateAppointment($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->_app, $data);
		if ($this->db->affected_rows() > 0){
			return true;
		}
		return false;

	}

	public function getAppointments()
	{
		$this->db->select('appointment.id, appointment.patient_id, appointment.appointment_date, appointment.appointment_time, CONCAT(patient.firstname, " " ,patient.middlename, " ", patient.lastname) as patientName, CONCAT(user.firstname, " ",user.lastname) as created_by ');
		$this->db->from($this->_user);
		$this->db->join($this->_app, 'user.id = appointment.userID');
		$this->db->join($this->_patient,'appointment.patient_id = patient.id');
		$this->db->where('appointment.status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function getUnavailableTime($date)
	{
		$this->db->select('appointment_time');
		$this->db->from($this->_app);
		$this->db->where('appointment_date',$date );
		$this->db->where('status', 1);
		$this->db->order_by('appointment_time', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function cancelAppointments($id, $status)
	{
		$this->db->where(array('id' => $id ));
		$this->db->update($this->_app, array('status' => $status));
		if ($this->db->affected_rows() > 0){
			return true;
		}
		return false;
	}


	public function calendarAppointments()
	{
		date_default_timezone_set('Asia/Manila');
		$this->db->select('appointment.appointment_date, patient.id, CONCAT(patient.lastname,",",patient.firstname) as patientName');
		$this->db->from($this->_app);
		$this->db->join($this->_patient,'appointment.patient_id = patient.id');
		$this->db->where('appointment.appointment_date >=', date('Y-m-d'));
		$this->db->where('appointment.status', 1);
		$this->db->order_by('appointment.appointment_created','ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function upcomingAppointments()
	{
		$date = date_add(new Datetime(), date_interval_create_from_date_string("2 days"));
		$this->db->select('appointment.appointment_date, appointment.appointment_time, CONCAT(patient.firstname, " " ,patient.middlename, " ", patient.lastname) as patientName');
		$this->db->from($this->_user);
		$this->db->join($this->_app, 'user.id = appointment.userID');
		$this->db->join($this->_patient,'appointment.patient_id = patient.id');
		$this->db->where('appointment.appointment_date BETWEEN "' . date('Y-m-d') . '" and "' . date_format($date, 'Y-m-d') . '"' );
		$this->db->where('appointment.status', 1);
		$this->db->order_by('appointment.appointment_date','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function getCurrentAppointments()
    {
		date_default_timezone_set('Asia/Manila');
		$this->db->select('appointment.id,appointment.patient_id, appointment.appointment_time, CONCAT(patient.firstname," ",patient.lastname) as patientName ');
		$this->db->from($this->_app);
		$this->db->join($this->_patient, 'appointment.patient_id = patient.id');
		$this->db->where('appointment_date', date('Y-m-d'));
		$this->db->where('status', 1);
		$this->db->order_by('appointment_time', 'asc');
        $query = $this->db->get();
        return $query->result();
	}

	public function getAllAppointments()
	{
		date_default_timezone_set('Asia/Manila');
		$this->db->select('appointment.id, appointment.appointment_date, appointment.patient_id, appointment.appointment_time, CONCAT(patient.firstname, " " ,patient.middlename, " ", patient.lastname) as patientName, CONCAT(user.firstname, " ",user.lastname) as created_by ');
		$this->db->from($this->_user);
		$this->db->join($this->_app, 'user.id = appointment.userID');
		$this->db->join($this->_patient,'appointment.patient_id = patient.id');
		$this->db->where('appointment.appointment_date >=', date('Y-m-d'));
		$this->db->where('appointment.status', 1);
		$query = $this->db->get();
		return $query->result();
	}
	public function disabledDate($date, $user)
	{
		$this->db->insert($this->_doc, array('na_date' => $date, 'userID' => $user));
		return;
	}

	public function getDisabledDates()
	{
		$this->db->select('na_date');
		$this->db->from($this->_doc);
		$query = $this->db->get();
		return $query->result();
	}

	public function fetchpendingSMS()
	{
		$today = new DateTime();
        $send_date = $today->format('Y-m-d');
		$this->db->select('sms.id, appointment.appointment_date, appointment.appointment_time, patient.lastname, patient.gender, patient.contact');
		$this->db->from($this->_sms);
		$this->db->join($this->_app, 'sms.appointment_id = appointment.id');
		$this->db->join($this->_patient, 'appointment.patient_id = patient.id');
		$this->db->where('appointment.status', 1);
		$this->db->where('sms.sms_status', 0);
		$query = $this->db->get();
		return $query;
	}

	public function mark_as_send($id)
	{
	   $this->db->where('id', $id);
	   if($this->db->update($this->_sms, array('sms_status' => 1))) {
		   return true;
	   }
	   return;
	}

	public function createSMS($data)
	{
		$this->db->insert($this->_sms, $data);
		return true;
	}

	public function sendTo($patient_id)
	{
		$this->db->select('patient.contact, patient.gender, patient.lastname');
		$this->db->from($this->_patient);
		$this->db->where("id", $patient_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function sendCC($doctor_id)
	{
		$this->db->select('user.contact, user.lastname');
		$this->db->from($this->_user);
		$this->db->where('id', $doctor_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function docID()
	{
		$this->db->select('user.id');
		$this->db->from($this->_user);
		$this->db->where('username', 'doctor');
		$query = $this->db->get();
		return $query->result();
	}


}


 ?>
