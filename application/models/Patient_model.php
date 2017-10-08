<?php

class Patient_model extends CI_Model
{
    private $_patient = 'patient';
    private $_primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function createPatient($data)
    {
        $query = $this->db->insert($this->_patient, $data);
        return $this->db->insert_id();
    }

    public function updatePatient($key, $data = array())
    {
        $this->db->where(array('id' => $key));
        $query = $this->db->update($this->_patient, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    public function patientList($key = array(), $flag = true)
    {
        if (! empty($key)) {
            if (is_array($key)) {
                $this->db->where($key);
            }
        }
        if ($flag){
          $this->db->select('consultation.height, consultation.height, patient.*');
          $this->db->from($this->_patient);
          $this->db->join('consultation', 'patient.id = consultation.patient_id and `consultation`.`id` in (select max(id) from consultation where consultation.patient_id = patient.id GROUP by consultation.patient_id)', 'left');
          $this->db->order_by('patient.date_created', 'desc');
          $query = $this->db->get();
        } else {
          $query = $this->db->get($this->_patient);
            
        }
        return $query->result();
    }

    public function getPatientName($name)
    {
        $this->db->select('id, concat(firstname," ", middlename, " ", lastname) as name');
        $this->db->having('name like', "%" . $name . "%");
        $this->db->limit(5);
        $this->db->from('patient');
        $query = $this->db->get();
        return $query->result();
    }

    public function patientQuarterStat()
    {
       $this->db->select('sum(case when QUARTER(date) = 1 then 1 else 0 end) as firstQuarter,
                          sum(case when QUARTER(date) = 2 then 1 else 0 end) as secondQuarter,
                          sum(case when QUARTER(date) = 3 then 1 else 0 end) as thirdQuarter,
                          sum(case when QUARTER(date) = 4 then 1 else 0 end) as fourthQuarter');
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
        $this->db->where('YEARWEEK(date, 3) =', date('YW'));
        $query = $this->db->get('consultation');
        return $query->row();
    }

    public function patientVisitType()
    {
        $this->db->select('sum(case when type="walk-in" then 1 else 0 end) as Walk_In, sum(case when type="appointment" then 1 else 0 end) as Appointment');
        $this->db->where('YEAR(date) =', date('Y'));
        $this->db->where('MONTH(date) =', date('m'));
        $this->db->from('consultation');
        $query = $this->db->get();
        return $query->row();

    }

    public function retrieveWH($patient_id)
    {
      $this->db->select('consultation.height, consultation.weight');
      $this->db->from('consultation');
      $this->db->where('consultation.patient_id', $patient_id);
      $this->db->order_by('consultation.id', 'desc');
      $this->db->limit(1);
      $query = $this->db->get();
      return $query->result();
    }

}
