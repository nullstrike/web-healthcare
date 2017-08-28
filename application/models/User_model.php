<?php

class User_model extends CI_Model
{
    //table name
    private $_table = 'user';
    private $_primary_key = 'userID';
    private $_relate_table = 'user_log';

    public function __construct()
    {
        parent:: __construct();
        $this->load->database();
        $this->user_default();
    }

    /*
     * Use: insert a default account
     */
    public function user_default()
    {
        $query = $this->userFetch();
        if ($query->num_rows() === 0) {
            $data = array(
                 'userName'     => 'doctor',
                 'userPassword' => 'default',
                 'userTitle'    => 'doctor'
            );
            $this->userInsert($data);
        }
    }

    /*
     * Use: update a user
     * @key = primary key
     * @data = value to be updated
     */
    public function userUpdate($key, $data)
    {
        $this->db->where(array($this->_primary_key => $key));
        $query = $this->db->update($this->_table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } 
        return false;
    }

    /*
     * Use: comparing hashed and unhashed password
     * @password = value from post
     * @hashed = value from database
     */
    public function verifyPassword($password,$hashed)
    {
        if (password_verify($password,$hashed)) {
            return true;
        }
        return false;
    }

    /*
     * Use: authenticating login details
     * @username = value from post
     * @password = value from post
     */
    public function authenticate($username, $password)
    {
        $query = $this->userFetch(array('userName' => $username))->result();
        if (count ($query)) {
            foreach ($query as $result) {
                //$hashed = $result['userPassword'];
                $hashed = $result->userPassword;
            }
            if ($this->verifyPassword($password, $hashed)) {
                return $query;
            }
            else
            {
                $row = $this->userFetch(array('userName' => $username, 'userPassword' => $password));
                if ($row->num_rows() === 1) {
                    return $row->result();
                }
            }
        }
    }

   public function userInsert($data)
   {
       $query = $this->db->insert($this->_table, $data);
       if ($query) {
          return $this->db->insert_id();
       }
       return false;
   }

   public function userFetch($key = array())
   {
        if (! empty($key)) {
             if (is_array($key)) {
                $this->db->where($key);
             }
        }
        $rows = $this->db->get($this->_table);
        return $rows;
   }

   public function checkuserLog($userID) 
   {
        $this->db->where('userID', $userID);
        $this->db->where("DATE_FORMAT(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
        $query = $this->db->get($this->_relate_table);
        return $query->num_rows();
   }
   public function createuserLog($logdata)
   {
       $this->db->insert($this->_relate_table, $logdata);
       return;
   }
   public function updateuserLog($userID, $logdata)
   {
       $this->db->where('userID', $userID);
       $this->db->where("DATE_FORMAT(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
       $this->db->update($this->_relate_table, array('log_datetime' => $logdata));
       return;
   }

}