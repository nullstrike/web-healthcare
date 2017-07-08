<?php

/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/6/17
 * Time: 2:21 PM
 */
//Base Model for reusable crud operation
class Base_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function add($table, $data)
    {
        $this->db->insert($table, $data);
        return true;
    }

    protected function update($key, $data, $table)
    {
        $this->db->where($key);
        $this->db->update($table, $data);
        return true;
    }

    protected function get_fullrow($table)
    {
        $rows = $this->db->get($table);
        return $rows->result();
    }

    protected function get_specific_rows($table, $key)
    {
        $rows = $this->db->get_where($table, $key);
        return $rows->result();
    }

    protected function get_join_rows($columns, $table, $join, $joinkey)
    {
        $this->db->select($columns)
            ->from($table)
            ->join($join, $joinkey);
        $rows = $this->db->get();
        return $rows->result();

    }

}