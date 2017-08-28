<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('patient_model','appointment_model'));
  }

  public function getPatientNum()
  {
     $query = $this->patient_model->patientNum();
     return $this->output->set_content_type('application/json')->set_output(json_encode($query));
  }

  public function getPatientQuarterStat()
  {
    $query = $this->patient_model->patientQuarterStat();
     if (isset($query)){
       $result[] = $query->firstQuarter;
       $result[] = $query->secondQuarter;
       $result[] = $query->thirdQuarter;
       $result[] = $query->fourthQuarter;
     }
     return $this->output->set_content_type('application/json')->set_output(json_encode($result));
  }

  public function getPatientWeeklyStat()
  {
    $query = $this->patient_model->patientWeeklyStat();

    if (isset($query)) {
        echo $query->WeekVisits;
    }
  }

  public function getPatientNewStat()
  {
    $query = $this->patient_model->patientNewStat();
    if (isset($query)) {
        echo $query->NewPatients;
    }
  }

}
