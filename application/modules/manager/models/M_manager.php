<?php


class M_manager extends CI_Model

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

    public function TotalNilaiRaimbusment($id)
    {
        $query = $this->db->query("SELECT sum(ammount) as total FROM trans_detail_jenis_pembayaran WHERE transaksi_jenis_pembayaran_id = '" . $id . "' ");
        return $query;
    }


    public function updateData($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarApprove($stat, $dept)
    {
        if ($stat != 0) {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr as approve , mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_mgr = '1' or mb.approve_mgr = '2' and mb.departement_id = '" . $dept . "'
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr as approve
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_mgr = '" . $stat . "' and mb.departement_id = '" . $dept . "'
             ");
        }

        return $query;
    }

    public function listTransaksi($dept, $stat)
    {
        $query = $this->db->query("SELECT tjp.id as id_trans  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , 
        (select(tdjp.ammount)) as total   ,
        tjp.approve_mgr , tjp.approve_acc  , tjp.lampiran  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join trans_detail_jenis_pembayaran tdjp  on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where tjp.master_departement_id  = '" . $dept . "' and tjp.approve_mgr  = '" . $stat . "' ");
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

    // request budget
    public function list_request($dept, $app, $stat)
    {
        $where = "";
        if ($app == 'mgr') {
            if ($stat == 0) {
                $where .= "trtb.approve_mgr  = 0 ";
            } else {
                $where .= "trtb.approve_mgr  != 0 ";
            }
        }
        $query =  $this->db->query("SELECT trtb.id ,  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  
        from  transaksi_request_tambah_budget trtb 
        inner join master_planning_budget mpb  on mpb.id_planing  = trtb.master_planning_budget_id_planing 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        where trtb.master_departement_id  = '" . $dept . "'  and $where  ");
        return $query;
    }
    //

}
