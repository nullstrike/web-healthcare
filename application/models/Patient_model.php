<?php
include "Base_model.php";
/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/6/17
 * Time: 3:20 PM
 */
class Patient_model extends Base_model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function add_patient($table,$data){
        $this->add($table,$data);
        return true;
    }
    public function update_patient($key,$data){
        $this->update('patient_id',$key,$data,'patient');
        return true;
    }
    public function view_patient(){
        $this->retrieve('')
    }
}