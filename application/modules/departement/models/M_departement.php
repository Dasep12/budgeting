<?php


class M_departement extends CI_Model

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

    public function daftarBudget()
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget,mb.tahun , mb.pic,mb.kpi,mb.improvment , mb.budget , mb.status , mjb.jenis_budget, md.nama_departement as departement  FROM master_budget mb , master_departement md , master_jenis_budget mjb WHERE mb.master_jenis_budget_id = mjb.id AND mb.departement_id = md.id  ");
        return $query;
    }

    public function ambilData($table, $where)
    {
        return  $this->db->get_where($table, $where);
    }

    public function multiInsert($data, $table)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarPlantBudgetDepartement($dept)
    {
        $query = $this->db->query("SELECT mb.kode_budget, md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity  FROM master_planning_budget  mpb
        left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        inner join master_departement md on mb.departement_id = md.id 
        WHERE mb.departement_id  = '" . $dept . "' ");
        return $query;
    }
}
