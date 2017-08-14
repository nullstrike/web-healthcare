<?php
/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/6/17
 * Time: 3:20 PM
 */
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

}