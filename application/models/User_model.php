<?php

class User_model extends Base_Model
{
    public $user_id;
    public $table = "user";
    public $flag;
    public $role;
    public $result;

    public function __construct()
    {
        parent:: __construct();
        $this->user_default();
    }

    public function user_default()
    {
        if ($this->count_rows($this->table) === 0) {
            $data =
                array(
                    "user_username" => "admin",
                    "user_userpass" => "default",
                    "user_type" => "admin"
                );
            $this->add($this->table, $data);

            return true;
        }
    }

    public function user_update($key, $data)
    {
        $this->update(array("user_id" => $key), $data, $this->table);
        return true;
    }

    public function view()
    {
        return parent::get_fullrow("user");
    }

    public function join_rows()
    {
        $columns = "user.user_firstname,user_log.log_date";
        return parent::get_join_rows($columns, "user", 'user_log', 'user.user_id = user_log.user_id');
    }
    public function verify_pass($password,$hashed){
        if(password_verify($password,$hashed)){
            return true;
        }
        return false;
   }
    public function login($username, $password){

        if($rows = parent::get_specific_rows($this->table,array("user_username" => $username))) {
            foreach ($rows as $row) {
                $hashed = $row['user_userpass'];
            }
            if ($verify_pass = $this->verify_pass($password, $hashed)) {
                return $rows;
            } else {
                $rows = parent::get_specific_rows($this->table, array("user_username" => $username, "user_userpass" => $password));
                if (count($rows)) {
                    return $rows;
                }
            }
        }
    }

    public function user_add($data){
        if(parent::add($this->table,$data)){
            return true;
        }
        return false;
    }

}