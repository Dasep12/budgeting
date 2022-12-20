<?php


class M_admin extends CI_Model
{
    public function getData($table)
    {
        $query = $this->db->get($table);
        return $query;
    }
    public function insert($data, $table)
    {
        $this->db->insert($data, $table);
        return $this->db->affected_rows();
    }

    public function updateData($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function ambilData($table, $where)
    {
        return  $this->db->get_where($table, $where);
    }

    // list tertanda
    public function getTertanda(Type $var = null)
    {
        $query = $this->db->query("SELECT * FROM master_tertanda ");
        return $query;
    }
}
