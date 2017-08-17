<?php

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
   
}
