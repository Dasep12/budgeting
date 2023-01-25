<?php


class M_supervisor extends CI_Model

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

    public function DetaildaftarPlantBudgetDepartement($id)
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget, mb.budget ,  md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity , mb.created_at  , mb.improvment , mb.pic  , mjb.jenis_budget  FROM master_planning_budget  mpb
        left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        left join master_jenis_budget mjb on mb.master_jenis_budget_id = mjb.id
        inner join master_departement md on mb.departement_id = md.id 
        WHERE mb.id_budget  = '" . $id . "' ");
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
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_spv as approve , mb.ket
            FROM master_budget mb 
             INNER JOIN master_departement md on mb.departement_id  = md.id 
             INNER JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.departement_id = $dept   and mb.approve_spv = '1' or mb.approve_spv = '2'
              GROUP BY mb.id_budget 
             ");
        } else {
            $query = $this->db->query("SELECT mb.id_budget , md.nama_departement  , mb.tahun , mb.kode_budget  , mjb.jenis_budget  , mb.budget , mb.status , mb.approve_mgr as approve
            FROM master_budget mb 
             INNER JOIN master_departement md on mb.departement_id  = md.id 
             INNER JOIN master_jenis_budget mjb on mjb.id  = mb.master_jenis_budget_id 
             WHERE mb.approve_spv = '" . $stat . "' and mb.departement_id = $dept 
             GROUP BY mb.id_budget
             ");
        }

        return $query;
    }

    public function listTransaksi($dept, $stat)
    {
        $st = "";

        if ($stat != 0) {
            $st .= 'tjp.approve_spv !=0';
        } else {
            $st .= 'tjp.approve_spv =0';
        }
        $query = $this->db->query("SELECT tjp.id as id_trans , tjp.id  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  ,  tjp.ket ,
        (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id ) as total    , ma.nama_lengkap , ma.nik,
        tjp.approve_mgr,tjp.approve_spv , tjp.approve_acc  , tjp.lampiran_1 ,tjp.lampiran_2 , tjp.lampiran_3  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id  
        left join master_akun ma on ma.nik = tjp.created_by 
        where $st  and tjp.master_departement_id = $dept
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
    public function list_request($dept, $app, $stat)
    {
        $where = "";
        if ($app == 'spv') {
            if ($stat == 0) {
                $where .= "trtb.approve_spv  = 0 ";
            } else {
                $where .= "trtb.approve_spv  != 0 ";
            }
        }
        $query =  $this->db->query("SELECT trtb.id ,  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  
        from  transaksi_request_tambah_budget trtb 
        inner join master_planning_budget mpb  on mpb.id_planing  = trtb.master_planning_budget_id_planing 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        where  $where  and trtb.master_departement_id='" . $dept . "' ");
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


    // voucher
    public function listVoucher($nik, $stat)
    {
        $where = "";

        if ($stat == 0) {
            $where .= "tpv.approve_spv=0";
        } else {
            $where .= "tpv.approve_spv=1 or tpv.approve_spv=2";
        }
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3, ma.nama_lengkap  as nama , mjt.jenis_transaksi ,
        (select sum(tdv.ammount_plant) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_mgr , tpv.approve_spv 
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_akun ma on ma.nik  = tpv.created_by 
        where  $where 
        group by tpv.request_code ");
        return $query;
    }

    public function listLaporVoucher($nik, $stat)
    {
        $where = "";

        if ($stat == 0) {
            $where .= "tpv.approve_lapor_spv=0";
        } else {
            $where .= "tpv.approve_lapor_spv=1 or tpv.approve_lapor_spv=2";
        }
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 , tpv.ket , 
        tpv.lampiran_2  , tpv.lampiran_3, ma.nama_lengkap  as nama , mjt.jenis_transaksi ,
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_spv ,tpv.approve_lapor_spv , tpv.plant_sebelumnya
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_akun ma on ma.nik  = tpv.created_by 
        where  $where  and tpv.stat_lapor = 1 
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
