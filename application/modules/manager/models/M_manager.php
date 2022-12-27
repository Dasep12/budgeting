<?php


class M_manager extends CI_Model

{
    public function getData($table)
    {
        $query = $this->db->get($table);
        return $query;
    }

    public function listDep($nik)
    {
        $query = $this->db->query("SELECT md.nama_departement , md.id FROM 
        master_bawahan_depthead  mbd
        LEFT JOIN master_akun ma on ma.nik = mbd.master_akun_nik
        LEFT JOIN master_departement md on md.id = mbd.master_departement_id
        where mbd.master_akun_nik = '" . $nik . "'
         ");
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

    public function daftarApprove($stat, $dept, $nik)
    {
        if ($stat != 0) {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr as approve , mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             INNER JOIN master_bawahan_depthead mhb on mhb.master_departement_id =  mb.departement_id
             WHERE mb.approve_mgr = '1' or mb.approve_mgr = '2' and mhb.master_akun_nik = '" . $nik . "'
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr as approve
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             INNER JOIN master_bawahan_depthead mhb on mhb.master_departement_id =  mb.departement_id
             WHERE mb.approve_mgr = '" . $stat . "' and mhb.master_akun_nik = '" . $nik . "'
             ");
        }

        return $query;
    }

    public function listTransaksi($dept, $stat, $nik)
    {
        $st = "";

        if ($stat != 0) {
            $st .= 'tjp.approve_mgr !=0';
        } else {
            $st .= 'tjp.approve_mgr =0';
        }
        $query = $this->db->query("SELECT tjp.id as id_trans , tjp.id  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  ,  tjp.ket ,
        (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id ) as total    , ma.nama_lengkap , ma.nik,
        tjp.approve_mgr , tjp.approve_acc  , tjp.lampiran_1 ,tjp.lampiran_2 , tjp.lampiran_3  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join master_bawahan_depthead mhb on mhb.master_departement_id =  tjp.master_departement_id
        left join master_akun ma on ma.nik = tjp.created_by 
        where $st 
        and mhb.master_akun_nik = '" . $nik . "' 
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

    // request budget
    public function list_request($nik, $app, $stat)
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
        left join master_bawahan_depthead mhb on mhb.master_departement_id =  trtb.master_departement_id
        where mhb.master_akun_nik  = '" . $nik . "'  and $where  ");
        return $query;
    }
    //

    // report budget plant
    public function getReportBudgetPlant($tahun, $jenis, $dept)
    {
        $query = $this->db->query("SELECT mb.id_budget as id , mb.kode_budget  , mb.target_kpi  , mb.pic ,mb.due_date , mb.budget , mb.improvment ,mb.created_at ,mb.kpi , mb.account_bame , mb.description , mb.created_at from  master_budget mb 
            left join master_jenis_budget mjb  on mjb.id = mb.master_jenis_budget_id
            WHERE mb.tahun='" . $tahun . "'  and mb.master_jenis_budget_id = '" . $jenis . "' and mb.approve_fin = 1 and mb.departement_id = '" . $dept . "'  ");
        return $query;
    }

    function getReportDetail($id, $bulan)
    {
        $query = $this->db->query("SELECT  mb.kode_budget  , mpb.bulan , mpb.nilai_budget , mpb.activity  from master_budget mb 
            left join master_planning_budget mpb on mpb.master_budget_id_budget  = mb.id_budget 
            WHERE mb.id_budget ='" . $id . "' and mpb.bulan  = '" . $bulan . "'
            order by mpb.id_planing  asc");
        return $query;
    }

    public function reportPayment($dept, $jenis, $start, $end)
    {
        $query = $this->db->query("SELECT tjp.id, tjp.tanggal_request  , concat('Rp. ',format(tdjp.ammount,0)) as ammount  , tdjp.particullar  , tjp.remarks  , tjp.request_code from transaksi_jenis_pembayaran tjp 
            inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id 
            where tjp.master_departement_id = '" . $dept . "' and tjp.tanggal_request  between  '" . $start . "' and '" . $end . "' and tjp.master_jenis_transaksi_id  = '" . $jenis . "' and tjp.approve_fin = 1   ");
        return $query;
    }
    //



}
