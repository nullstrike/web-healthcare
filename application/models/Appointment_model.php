<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment_model extends CI_Model
{
	private $_table = 'appointment';
	private $_related_table = 'patient';
	private $_fields = array();
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createEvent($data)
	{
		if (! empty($data)) {
			$this->db->where($data);
		}
		$query = $this->db->get($this->_table);

		if ($query->num_rows() === 0) {
			$this->db->insert($this->_table, $data);
			return true;
		} else {
			return false;
		}

	}
	public function updateEvent($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('appointment', $data);
		if ($this->db->affected_rows() > 0){
			return true;
		}
		return false;
	
	}
	public function getAppointments()
	{
		$this->db->select('appointment.appointment_date as appointment_date, CONCAT(user.firstname, " ", user.lastname) as created_by, CONCAT(patient.firstname, " ", patient.middlename, " ",patient.lastname) as patient_name');
		$this->db->from('user');
		$this->db->join('appointment','user.id = appointment.userid');
		$this->db->join('patient', 'appointment.patient_id = patient.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAvailableTime($date)
	{
		$this->db->select('appointment_time');
		$this->db->from('appointment');
		$this->db->where('appointment_date',$date );
		$this->db->where('status', 1);
		$this->db->order_by('appointment_time', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function cancelAppointments($id, $status)
	{
		$this->db->where(array('id' => $id));
		$this->db->update('appointment', array('status' => $status));
		if ($this->db->affected_rows() > 0){
			return true;
		}
		return false;
	}


	public function fetchEvents()
	{
		date_default_timezone_set('Asia/Manila');
		$this->db->select('appointment.*, CONCAT(patient.lastname,",",patient.firstname) as patientName');
		$this->db->from($this->_table);
		$this->db->join($this->_related_table,'appointment.patient_id = patient.id');
		$this->db->where('appointment_date >=', date('Y-m-d'));
		$this->db->where('status', 1);
		$this->db->order_by('appointment.appointment_created','ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function upcomingEvents()
	{
		$date = date_add(new Datetime(), date_interval_create_from_date_string("2 days"));
		$this->db->select('appointment.id, appointment.appointment_date, appointment.patient_id, appointment.appointment_time, CONCAT(patient.firstname, " " ,patient.middlename, " ", patient.lastname) as patientName, CONCAT(user.firstname, " ",user.lastname) as created_by ');
		$this->db->from('user');
		$this->db->join('appointment', 'user.id = appointment.userID');
		$this->db->join($this->_related_table,'appointment.patient_id = patient.id');
		$this->db->where('appointment.appointment_date BETWEEN "' . date('Y-m-d') . '" and "' . date_format($date, 'Y-m-d') . '"' );
		$this->db->where('appointment.status', 1);
		$this->db->order_by('appointment.appointment_date','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function getAppointmentsToday()
    {
		date_default_timezone_set('Asia/Manila');
		$this->db->select('appointment.id,appointment.patient_id, appointment.appointment_time, CONCAT(patient.firstname," ",patient.lastname) as patientName ');
		$this->db->from('appointment');
		$this->db->join('patient', 'appointment.patient_id = patient.id');
		$this->db->where('appointment_date', date('Y-m-d'));
		$this->db->where('status', 1);
		$this->db->order_by('appointment_time', 'asc');
        $query = $this->db->get();
        return $query->result();
	}

	public function disabledDate($data)
	{
		$this->db->insert('doctor_schedule', $data);
		return;
	}

	public function fetchdisabledDates()
	{
		$this->db->select('na_date');
		$this->db->from('doctor_schedule');
		$query = $this->db->get();
		return $query->result();
	}
	

}


 ?>
