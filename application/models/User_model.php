<?php

class User_model extends CI_Model
{

    private $_user = 'user';
    private $_log  = 'user_log';

    public function __construct()
    {
        parent:: __construct();
        $this->createUserDefault();
    }

    /*
     * Use: insert a default account
     */
    public function createUserDefault()
    {
        $query = $this->getUsers(array('username' => 'doctor'));
        $data = array(
            'username'     => 'doctor',
            'password'     => 'default',
            'usertitle'    => 'doctor'
       );
        if ($query->num_rows() === 0) {
            $this->createUser($data);
        }
    }

    /*
     * Use: update a user
     * @key = primary key
     * @data = value to be updated
     */
    public function updateUser($key, $data)
    {
        $this->db->where(array('id' => $key));
        $query = $this->db->update($this->_user, $data);
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
    public function verifyPassword($password, $hashed)
    {
        if (password_verify($password, $hashed)) {
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
        $query = $this->getUsers(array('username' => $username))->result();
        if (count ($query)) {
            foreach ($query as $result) {
                $hashed = $result->password;
            }
            if ($this->verifyPassword($password, $hashed)) {
                return $query;
            }
            else
            {
                $row = $this->getUsers(array('username' => $username, 'password' => $password));
                if ($row->num_rows() === 1) {
                    return $row->result();
                }
            }
        }
    }

   public function createUser($data)
   {
       $query = $this->db->insert($this->_user, $data);
       return true;
   }

   public function getUsers($key = array())
   {
        if (! empty($key)) {
             if (is_array($key)) {
                $this->db->where($key);
             }
        }
      $rows = $this->db->get($this->_user);
      return $rows;
   }

   public function checkUserLog($userID)
   {
        $this->db->where('userID', $userID);
        $this->db->where("date_format(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
        $query = $this->db->get($this->_log);
        return $query->num_rows();
   }
   public function createuserLog($logdata)
   {
       $this->db->insert($this->_log, $logdata);
       return;
   }
   public function updateUserLog($userID, $logdata)
   {
       $this->db->where('userID', $userID);
       $this->db->where("date_format(log_datetime,'%Y-%m-%d')", date('Y-m-d'));
       $this->db->update($this->_log, array('log_datetime' => $logdata));
       return;
   }
   public function getUserLogs()
   {
      $this->db->select('user.usertitle, user.username, user_log.log_datetime');
      $this->db->from($this->_user);
      $this->db->join($this->_log, 'user.id = user_log.userID');
      $query = $this->db->get();
      return $query->result();
   }

}
