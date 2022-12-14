<?php


class M_bc extends CI_Model

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

    public function TotalNilaiRaimbusment($id)
    {
        $query = $this->db->query("SELECT sum(ammount) as total FROM trans_detail_jenis_pembayaran WHERE transaksi_jenis_pembayaran_id = '" . $id . "' ");
        return $query;
    }

    public function listTransaksi($stat)
    {
        $query = $this->db->query("SELECT tjp.id as id_trans  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , 
        (select(tdjp.ammount)) as total   ,
        tjp.approve_mgr   , tjp.approve_acc , tjp.lampiran  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join trans_detail_jenis_pembayaran tdjp  on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where tjp.approve_acc  = '" . $stat . "' and tjp.approve_mgr = 1    ");
        return $query;
    }


    public function daftarApprove($stat)
    {
        if ($stat ==  0) {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr , mb.approve_bc , mb.ket
            FROM master_budget mb  
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id
             WHERE mb.approve_bc = '" . $stat . "'
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr , mb.approve_bc , mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_bc = '1' or mb.approve_bc = '2' 
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


    // request budget
    public function list_request($app, $stat)
    {
        $where = "";
        if ($app == 'bc') {
            if ($stat == 0) {
                $where .= "trtb.approve_mgr  = 1  and trtb.approve_bc = 0 ";
            } else {
                $where .= "trtb.approve_bc  != 0  ";
            }
        }
        $query =  $this->db->query("SELECT trtb.id ,  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  
        from  transaksi_request_tambah_budget trtb 
        inner join master_planning_budget mpb  on mpb.id_planing  = trtb.master_planning_budget_id_planing 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        where  $where  ");
        return $query;
    }
    //
}
