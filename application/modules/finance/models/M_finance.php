<?php


class M_finance extends CI_Model

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

    public function inserData($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
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

    public function listTransaksi($dept, $stat)
    {
        $query = $this->db->query("SELECT tjp.id as id_trans , tjp.id ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , 
       (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id ) as total    , ma.nama_lengkap , ma.nik,
        tjp.approve_gm   , tjp.approve_fin , tjp.lampiran_1 , tjp.lampiran_2 ,tjp.lampiran_3  , tjp.tanggal_request , tjp.ket  , tjp.payment_close as pcl , mby.jenis_bayar as bayar
        from transaksi_jenis_pembayaran tjp 
        left join master_akun ma on ma.nik = tjp.created_by 
        left join master_bayar mby on mby.id = tjp.master_jenis_bayar_id 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        where tjp.approve_fin  = '" . $stat . "' and tjp.approve_gm = 1 and tjp.master_jenis_bayar_id = '" . $dept . "' ");
        return $query;
    }

    public function daftarApprove($stat)
    {
        if ($stat == 0) {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_fin , mb.approve_mgr , mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_gm = '1' and mb.approve_fin = '0'
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_fin , mb.approve_mgr, mb.ket
            FROM master_budget mb 
             LEFT JOIN master_departement md on mb.departement_id  = md.id 
             LEFT JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_fin = '1' or mb.approve_fin = '2'
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

    public function reportPayment($dept, $jenis, $start, $end)
    {
        $query = $this->db->query("SELECT tjp.id, tjp.tanggal_request  , concat('Rp. ',format(tdjp.ammount,0)) as ammount   , tdjp.particullar  , tjp.remarks  , tjp.request_code from transaksi_jenis_pembayaran tjp 
        inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id 
        where tjp.master_departement_id = '" . $dept . "' and tjp.tanggal_request  between  '" . $start . "' and '" . $end . "' and tjp.master_jenis_transaksi_id  = '" . $jenis . "' and tjp.approve_fin = 1   ");
        return $query;
    }

    // request budget
    public function list_request($app, $stat)
    {
        $where = "";
        if ($app == 'fin') {
            if ($stat == 0) {
                $where .= "trtb.approve_gm  = 1  and trtb.approve_fin = 0 ";
            } else {
                $where .= "trtb.approve_fin  != 0  ";
            }
        }
        $query =  $this->db->query("SELECT trtb.id ,  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  ,  mb.id_budget as id_budget  ,  mpb.id_planing as id_plant
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
        WHERE mb.tahun='" . $tahun . "'  and mb.master_jenis_budget_id = '" . $jenis . "' and mb.approve_fin = 1 and mb.departement_id = '" . $dept . "'   ");
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
    // 

    // report jurnal
    function getReportJurnal($tgl1, $tgl2, $dept)
    {
        $query = $this->db->query("SELECT tjp.tanggal_request as tanggal , tjp.request_code  , md.nama_departement  , tjp.bk ,
        ma.ket , ma.acc_no , ma.acc_name ,
        (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id  ) as debit
        from transaksi_jenis_pembayaran tjp 
        inner join master_acc ma on ma.id = tjp.master_acc_id 
        inner join master_departement md on tjp.master_departement_id  = md.id
        where tjp.tanggal_request between '" . $tgl1 . "' and '" . $tgl2 . "' and tjp.master_departement_id  = '" . $dept . "' 
        and tjp.approve_fin  = 1 ");
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

    public function listVoucher($stat)
    {
        $where = "";

        if ($stat == 0) {
            $where .= "tpv.approve_gm=1 and tpv.approve_fin =0";
        } else {
            $where .= "tpv.approve_gm=1 and tpv.approve_fin=1 or tpv.approve_fin=2";
        }
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3,  tpv.approve_fin ,tpv.approve_gm ,
        mjt.jenis_transaksi ,
        (select nama_lengkap from master_akun where nik = tpv.created_by )as nama,
        (select sum(tdv.ammount_plant) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_mgr 
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        where $where 
        group by tpv.request_code ");
        return $query;
    }

    public function listLaporVoucher($stat)
    {
        $where = "";

        if ($stat == 0) {
            $where .= "tpv.approve_lapor_gm=1 and tpv.approve_lapor_fin=0";
        } else {
            $where .= "tpv.approve_lapor_gm=1 and tpv.approve_lapor_fin=1 or tpv.approve_lapor_fin=2";
        }
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3,        
        mjt.jenis_transaksi ,
        (select nama_lengkap from master_akun where nik = tpv.created_by )as nama,
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_mgr ,tpv.approve_lapor_bc , tpv.plant_sebelumnya,tpv.approve_lapor_gm
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
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
