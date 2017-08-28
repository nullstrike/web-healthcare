<?php

class Patient_model extends CI_Model
{
    private $_table = 'patient';
    private $_primary_key = 'patient_id';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insertPatient($data){
        $query = $this->db->insert($this->_table, $data);
        if ($query) {
            return $this->db->insert_id();
        }
        return;
    }
    public function updatePatient($key, $data = array()){
        $this->db->where(array($this->_primary_key => $key));
        $query = $this->db->update($this->_table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    public function patientList($key = array()) {
        if (! empty($key)) {
            if (is_array($key)) {
                $this->db->where($key);
            }
        }
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    public function patient_oldData(){
        $query = $this->db->insert($this->_table, $data);
        if ($query) {
            return true;
        }
        return false;
    }
    public function addConsultation($data){
        $query = $this->db->insert('consultation', $data);
        if ($query) {
            return true;
        }
        return false;
    }
    public function patientQuarterStat()
    {
       $this->db->select('sum(case when QUARTER(consultation_date) = 1 then 1 else 0 end) as firstQuarter,
                          sum(case when QUARTER(consultation_date) = 2 then 1 else 0 end) as secondQuarter,
                          sum(case when QUARTER(consultation_date) = 3 then 1 else 0 end) as thirdQuarter,
                          sum(case when QUARTER(consultation_date) = 4 then 1 else 0 end) as fourthQuarter');
      $query = $this->db->get('consultation');
      return $query->row();
    }

    public function patientNum()
    {
      $query = $this->db->count_all('patient');
      return $query;
    }

    public function patientWeeklyStat()
    {
      $this->db->select('count(*) as WeekVisits');
      $this->db->where('YEARWEEK(consultation_date, 3) =', date('YW'));
      $query = $this->db->get('consultation');
      return $query->row();
    }

    public function patientNewStat()
    {
      $this->db->select('count(*) as NewPatients');
      $this->db->where('YEARWEEK(date_created, 3) =', date('YW'));
      $query = $this->db->get('patient');
      return $query->row();

    }


}
