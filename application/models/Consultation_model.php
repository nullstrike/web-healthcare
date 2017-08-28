<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultation_model extends CI_Model
{
    private $_table = 'consultation';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    public function insertConsultation($data)
    {
        if (! empty($data)){
            foreach ($data as $key => $val) {
               if ($key === 'patient_id'){
                   $this->db->where($key, $val);
               } else if ($key === 'consultation_date'){
                   $this->db->where($key, $val);
               }
            }
        }
        $query = $this->db->get($this->_table);
        if ($query->num_rows() === 0) {
            $this->db->insert($this->_table, $data);
            return true;
        } else {
            return false;
        }
    }
    public function getConsultation($key)
    {
        $this->db->where('patient_id', $key);
        $this->db->order_by('consultation_date', 'desc');
        $query = $this->db->get($this->_table);
        if ($query) {
            return $query->result_array();
        }
        return;
    }
    public function getConsultationbyDate($patient_id, $start, $end)
    {
        if (! empty($start) && ! empty($end)) {
            $this->db->where('patient_id', $patient_id);
            $this->db->where('consultation_date BETWEEN "'. $start . '" and "' . $end . '"');
            $query = $this->db->get('consultation');
            return $query->result_array();
        }
    }
   
}
