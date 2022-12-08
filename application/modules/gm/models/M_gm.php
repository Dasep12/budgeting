<?php


class M_gm extends CI_Model

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

    public function listTransaksi($dept, $stat)
    {
        $query = $this->db->query("SELECT tjp.id as id_trans  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , 
        (select(tdjp.ammount)) as total   ,
        tjp.approve_gm   , tjp.approve_acc , tjp.lampiran  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join trans_detail_jenis_pembayaran tdjp  on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where tjp.approve_acc  = '" . $stat . "' ");
        return $query;
    }

    public function daftarApprove($stat)
    {

        if ($stat == 0) {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_gm , mb.approve_bc,mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_bc = '1' and mb.approve_gm = 0
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_gm , mb.approve_bc , mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_gm = '1' or mb.approve_gm = '2'
             ");
        }
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
