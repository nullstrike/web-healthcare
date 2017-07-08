<?php
include "Base_model.php";

/**
 * Created by SublimeText.
 * User: n3far1ous
 * Date: 7/5/17
 * Time: 1:25 PM
 */
class User_model extends Base_model
{
    public function __construct()
    {
        parent:: __construct();
        $this->user_add();
    }

    public function user_add()
    {
        if ($rows = $this->count_row() < 2) {
            $data = array(
                array(
                    "user_username" => "doctor",
                    "user_userpass" => "default",
                    "user_type" => "admin"
                ),
                array(
                    "user_username" => "staff",
                    "user_userpass" => "default",
                    "user_type" => "normal"
                ),
            );

            for ($i = 0; $i < 2; $i++) {
                $this->add('user', $data[$i]);
            }
            return true;
        }
        return;
    }

    public function count_row()
    {
        $result = $this->db->count_all('user');
        return $result;
    }

    public function update_user($key, $data)
    {
        $this->update($key, $data, 'user');

        return $this->db->affected_rows();
    }

    public function view()
    {
        return parent::get_fullrow("user");
    }

    public function auths($key)
    {
        return parent::get_specific_rows("user", $key);
    }

    public function join_rows()
    {
        $columns = "user.user_firstname,user_log.log_date";
        return parent::get_join_rows($columns, "user", 'user_log', 'user.user_id = user_log.user_id');
    }

    public function auth($username, $password)
    {
        $rows = parent::get_specific_rows('user', array("user_username" => $username));
        foreach ($rows as $result) {
            $hashed = $result->user_userpass;
        }
        if (password_verify($password, $hashed)) {
            return true;
        } else {
            return false;
        }
    }
}