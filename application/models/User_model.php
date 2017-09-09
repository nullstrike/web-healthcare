<?php

class User_model extends CI_Model
{

    public function __construct()
    {
        parent:: __construct();
        $this->user_default();
    }

    /*
     * Use: insert a default account
     */
    public function user_default()
    {
        $query = $this->userFetch(array('username' => 'doctor'));
        $data = array(
            'username'     => 'doctor',
            'password'     => 'default',
            'usertitle'    => 'doctor'
       );
        if ($query->num_rows() === 0) { 
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
        $this->db->where(array('id' => $key));
        $query = $this->db->update('user', $data);
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
        $query = $this->userFetch(array('username' => $username))->result();
        if (count ($query)) {
            foreach ($query as $result) {
                $hashed = $result->password;
            }
            if ($this->verifyPassword($password, $hashed)) {
                return $query;
            }
            else
            {
                $row = $this->userFetch(array('username' => $username, 'password' => $password));
                if ($row->num_rows() === 1) {
                    return $row->result();
                }
            }
        }
    }

   public function userInsert($data)
   {
       $query = $this->db->insert('user', $data);
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
      $rows = $this->db->get('user');
      return $rows;
   }

   public function resetData()
   {
      
   }
//    public function checkuserLog($userID)
//    {
//         $this->db->where('userID', $userID);
//         $this->db->where("DATE_FORMAT(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
//         $query = $this->db->get('userlog');
//         return $query->num_rows();
//    }
//    public function createuserLog($logdata)
//    {
//        $this->db->insert('userlog', $logdata);
//        return;
//    }
//    public function updateuserLog($userID, $logdata)
//    {
//        $this->db->where('userID', $userID);
//        $this->db->where("DATE_FORMAT(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
//        $this->db->update('userlog', array('log_datetime' => $logdata));
//        return;
//    }

}
