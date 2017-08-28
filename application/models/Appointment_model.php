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

	public function fetchPatientName()
	{
		$this->db->select('patient_id, CONCAT(patient_lname,",",patient_fname) as patientName');
		$query = $this->db->get('patient');
		return $query->result();
	}

	public function fetchEvents()
	{
		$this->db->select('appointment.*, CONCAT(patient.patient_lname,",",patient.patient_fname) as patientName');
		$this->db->from($this->_table);
		$this->db->join($this->_related_table,'appointment.patient_id = patient.patient_id');
		$this->db->where('appointment_date >=', date('Y-m-d'));
		$this->db->order_by('appointment.appointment_created','ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function upcomingEvents()
	{
		$date = date_add(new Datetime(), date_interval_create_from_date_string("2 days"));
		$this->db->select('appointment.appointment_date, CONCAT(patient.patient_fname, " " ,patient.patient_mname, " ", patient.patient_lname) as patientName');
		$this->db->from($this->_table);
		$this->db->join($this->_related_table,'appointment.patient_id = patient.patient_id');
		$this->db->where('appointment_date BETWEEN "' . date('Y-m-d') . '" and "' . date_format($date, 'Y-m-d') . '"' );
		$this->db->order_by('appointment.appointment_date','ASC');
		$query = $this->db->get();
		return $query->result();
	}
}


 ?>
