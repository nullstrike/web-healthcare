<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    public function __construct($rules = array())
    {
        // Pass the $rules to the parent constructor.
        parent::__construct($rules);
        // $this->CI is assigned in the parent constructor, no need to do it here.
    }

    public function is_required($str)
    {
        if (empty($str))
        {
            $this->CI->form_validation->set_message('is_required', 'The %s is required');
            return FALSE;
        }

        return TRUE;
    }

    public function number_check($str)
    {

        if (!preg_match('/^\+?\d*$/', $str)) {
            $this->form_validation->set_message('number_check', 'The %s field must only contain numeric and plus sign');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
