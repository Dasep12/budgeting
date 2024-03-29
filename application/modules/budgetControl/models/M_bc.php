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

    public function delete($data, $table)
    {
        $this->db->where($data);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function TotalNilaiRaimbusment($id)
    {
        $query = $this->db->query("SELECT sum(ammount) as total FROM trans_detail_jenis_pembayaran WHERE transaksi_jenis_pembayaran_id = '" . $id . "' ");
        return $query;
    }

    public function listTransaksi($stat)
    {
        $query = $this->db->query("SELECT  mb.kode_budget ,  tjp.id as id_trans , tjp.id  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , 
        (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id ) as total    , ma.nama_lengkap , ma.nik,
        tjp.approve_mgr   , tjp.approve_acc , tjp.lampiran_1 ,tjp.lampiran_2 ,tjp.lampiran_3  , tjp.tanggal_request , tjp.ket 
        from transaksi_jenis_pembayaran tjp 
        left join master_akun ma on ma.nik = tjp.created_by 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_planning_budget mpb on tjp.master_planning_budget_id_planing = mpb.id_planing
        left join master_budget mb on mb.id_budget = mpb.master_budget_id_budget
        left join master_departement md  on md.id  = tjp.master_departement_id  
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
             WHERE mb.approve_bc = '" . $stat . "' and mb.approve_mgr = 1 
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

    public function DetaildaftarPlantBudgetDepartement($id)
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget, mb.budget ,  md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity , mb.created_at  , mb.improvment , mb.pic  , mjb.jenis_budget  FROM master_planning_budget  mpb
        left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        left join master_jenis_budget mjb on mb.master_jenis_budget_id = mjb.id
        inner join master_departement md on mb.departement_id = md.id 
        WHERE mb.id_budget  = '" . $id . "' ");
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

    // dashboard
    public function getDept(Type $var = null)
    {
        $data = array();
        $query = $this->db->get("master_departement");
        foreach ($query->result_array() as $key => $rso) {
            $data[] = $rso['nama_departement'];
        }

        return json_encode($data, true);
    }
    // 

    public function listVoucher($nik, $stat)
    {
        $where = "";

        if ($stat == 0) {
            $where .= "tpv.approve_mgr=1 and tpv.approve_acc =0";
        } else {
            $where .= "tpv.approve_mgr=1 and tpv.approve_acc=1 or tpv.approve_acc=2";
        }
        $query = $this->db->query("SELECT mb.kode_budget ,  tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3,  tpv.approve_acc , mjt.jenis_transaksi ,
        (select nama_lengkap from master_akun where nik = tpv.created_by )as nama,
        (select sum(tdv.ammount_plant) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_mgr 
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_planning_budget mpb on tpv.master_planning_budget_id_planing = mpb.id_planing
        inner join master_budget mb on mb.id_budget = mpb.master_budget_id_budget
        where $where 
        group by tpv.request_code ");
        return $query;
    }

    public function listLaporVoucher($stat)
    {
        $where = "";
        if ($stat == 0) {
            $where .= "tpv.approve_lapor_mgr=1 and tpv.approve_lapor_bc=0";
        } else {
            $where .= "tpv.approve_lapor_mgr=1 and tpv.approve_lapor_bc=1 or tpv.approve_lapor_bc=2";
        }
        $query = $this->db->query("SELECT mb.kode_budget, tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3,mjt.jenis_transaksi ,
        (select nama_lengkap from master_akun where nik = tpv.created_by )as nama,
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_mgr ,tpv.approve_lapor_mgr , tpv.plant_sebelumnya,tpv.approve_lapor_bc
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_planning_budget mpb on tpv.master_planning_budget_id_planing = mpb.id_planing
        inner join master_budget mb on mb.id_budget = mpb.master_budget_id_budget
        inner join master_bawahan_depthead mbd on mbd.master_departement_id  = tpv.master_departement_id 
        where $where  and tpv.stat_lapor = 1 
        group by tpv.request_code ");
        return $query;
    }


    public function reportVoucher($dept, $jenis, $start, $end)
    {
        $query = $this->db->query("SELECT tjp.id, tjp.tanggal_request  , concat('Rp. ',format(tdjp.ammount,0)) as ammount  , tdjp.particullar  , tjp.remarks  , tjp.request_code , ma.nama_lengkap as nama 
        from transaksi_jenis_pembayaran tjp 
        inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id 
        inner join master_akun ma on ma.nik  = tjp.created_by 
        where tjp.master_departement_id = '" . $dept . "' and tjp.tanggal_request  between  '" . $start . "' and '" . $end . "' and tjp.master_jenis_transaksi_id  = '" . $jenis . "' and tjp.approve_fin = 1   ");
        return $query;
    }
}
