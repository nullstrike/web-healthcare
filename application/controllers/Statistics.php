<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('patient_model','appointment_model'));
  }

  public function getStats()
  {
      $stats = array(
        "totalpatient"       => $this->getPatientNum(),
        "patientquarterstat" => $this->getPatientQuarterStat(),
        "patientweekstat"    => $this->getPatientWeeklyStat(),

      );
      return $this->output->set_content_type('application/json')->set_output(json_encode($stats));
  }

  private function getPatientNum()
  {
     $query = $this->patient_model->patientNum();
     return $query;
  }

  private function getPatientQuarterStat()
  {
    $query = $this->patient_model->patientQuarterStat();
     if (isset($query)){
       $result[] = $query->firstQuarter;
       $result[] = $query->secondQuarter;
       $result[] = $query->thirdQuarter;
       $result[] = $query->fourthQuarter;
     }
     return $query;
  }

  private function getPatientWeeklyStat()
  {
    $query = $this->patient_model->patientWeeklyStat();

    if (isset($query)) {
        return $query->WeekVisits;
    }
    return;
  }

  private function getPatientNewStat()
  {
    $query = $this->patient_model->patientNewStat();
    if (isset($query)) {
        return $query->NewPatients;
    }
    return;
  }

}
