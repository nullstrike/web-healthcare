<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultation_model extends CI_Model
{
    private $_consult = 'consultation';
    private $_app = 'appointment';
    private $_pay = 'payment';
    private $_patient = 'patient';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('appointment_model');
    }

    public function createConsultation($data)
    {
        $this->db->insert($this->_consult, $data);
        return true;
    }

    public function completeAppointment($id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->_app, array('status' => 2));
		return true;
    }

    public function getConsultation($key)
    {
        $this->db->where('patient_id', $key);
        $this->db->order_by('date', 'desc');
        $query = $this->db->get($this->_consult);
        return $query->result();
    }

    public function getConsultationbyDate($patient_id, $start, $end)
    {
        if (! empty($start) && ! empty($end)) {
            $this->db->where('patient_id', $patient_id);
            $this->db->where('date BETWEEN "'. $start . '" and "' . $end . '"');
            $query = $this->db->get($this->_consult);
            return $query->result_array();
        }
    }

    public function createPayment($data)
    {
      if ($this->db->insert($this->_pay, $data)){
        return true;
      } else {
        return false;
      }
    }

    public function getReports()
    {
        $this->db->select('`consultation`.`id`, concat(`patient`.`firstname`, " ",`patient`.`middlename`, " ", `patient`.`lastname`) as `patientName`, `consultation`.`diagnosis`, `consultation`.`medication`, `consultation`.`date`');
        $this->db->from($this->_patient);
        $this->db->join($this->_consult, 'patient.id = consultation.patient_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getDiagnosis($id)
    {
        $this->db->select('concat(`patient`.`lastname`, ", ", `patient`.`firstname`) as patientName,
                          `patient`.`birthdate`, `patient`.`gender`,`patient`.`age`,
                          `patient`.`bloodtype`, `consultation`.`height`, `consultation`.`weight`,
                          `consultation`.`diagnosis`, `consultation`.`date`');
        $this->db->from($this->_patient);
        $this->db->join($this->_consult, 'patient.id = consultation.patient_id');
        $this->db->where('consultation.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPrescription($id)
    {
        $this->db->select('concat(`patient`.`lastname`, ", ", `patient`.`firstname`) as patientName, `patient`.`address`,
                           `consultation`.`medication`, `consultation`.`note`, `consultation`.`date` ');
        $this->db->from($this->_patient);
        $this->db->join($this->_consult, 'patient.id = consultation.patient_id');
        $this->db->where('consultation.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getReceipt($id)
    {
        $this->db->select('concat(`patient`.`lastname`, ", ", `patient`.`firstname`) as patientName,
                          `payment`.`payment_amount`, `payment`.`payment_given`,
                          (`payment`.`payment_given` - `payment`.`payment_amount`) as payment_change, `consultation`.`date`');
        $this->db->from($this->_pay);
        $this->db->join($this->_consult, 'payment.consultation_id = consultation.id');
        $this->db->join($this->_patient, 'patient.id =  consultation.patient_id');
        $this->db->where('consultation.id', $id);
        $query = $this->db->get();
        return $query->result();
    }


}
