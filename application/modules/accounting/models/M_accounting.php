<?php


class M_accounting extends CI_Model

{
    public function getData($table)
    {
        $query = $this->db->get($table);
        return $query;
    }
    public function ambilData($table, $where)
    {
        return  $this->db->get_where($table, $where);
    }

    public function updateData($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarApprove($stat)
    {
        $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_fin , mb.approve_acc
        FROM master_budget mb 
         LEFT JOIN master_departement md on mb.departement_id  = md.id 
         LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
         WHERE mb.approve_fin = '" . $stat . "'
         ");
        return $query;
    }

    public function detailBudget($id)
    {
        $query = $this->db->query("SELECT mb.id_budget  , mb.tahun  , mpb.activity , mb.kode_budget ,mpb.kode_plant_activity  from master_budget mb 
        left join master_planning_budget mpb ON mpb.master_budget_id_budget  = mb.id_budget 
        WHERE mb.id_budget = '" . $id . "' 
        group  by mpb.activity 
         ");
        return $query;
    }
}
