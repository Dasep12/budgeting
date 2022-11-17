<?php


class M_finance extends CI_Model

{
    public function getData($table)
    {
        $query = $this->db->get($table);
        return $query;
    }

    public function updateData($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarApprove()
    {
        $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status
        FROM master_budget mb 
         LEFT JOIN master_departement md on mb.departement_id  = md.id 
         LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
         ");
        return $query;
    }
}
