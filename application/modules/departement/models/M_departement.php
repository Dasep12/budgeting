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

    public function delete($data, $table)
    {
        $this->db->where($data);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function daftarBudget($id)
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget,mb.tahun , mb.pic,mb.kpi,mb.improvment , mb.budget , mb.status , mjb.jenis_budget, md.nama_departement as departement , mb.ket , mb.approve_mgr , mb.approve_mgr_user, mb.approve_fin , mb.approve_fin_user, mb.approve_acc , mb.approve_acc_user , mb.approve_gm , mb.approve_gm_user FROM master_budget mb , master_departement md , master_jenis_budget mjb WHERE mb.master_jenis_budget_id = mjb.id AND mb.departement_id = md.id AND mb.departement_id='" . $id  . "'  ");
        return $query;
    }

    public function TotalNilaiRaimbusment($id)
    {
        $query = $this->db->query("SELECT sum(ammount) as total FROM trans_detail_jenis_pembayaran WHERE transaksi_jenis_pembayaran_id = '" . $id . "' ");
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

    public function multiInsert($data, $table)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarPlantBudgetDepartement($dept)
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget, mb.budget ,  md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity , mb.created_at , mb.approve_mgr , mb.approve_spv , mb.approve_bc , mb.approve_fin    FROM master_planning_budget  mpb
        left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        inner join master_departement md on mb.departement_id = md.id 
        WHERE mb.departement_id  = '" . $dept . "'  group by mb.kode_budget
        order by mb.created_at desc ");

        // $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget , mb.tahun , md.nama_departement  , mb.budget , mpb.activity  ,  sum(mpb.nilai_budget) as total , mpb.kode_plant_activity as kp
        // from master_budget mb 
        // left join master_planning_budget mpb on mb.id_budget  = mpb.master_budget_id_budget
        // left join master_departement md  on md.id =  mb.departement_id 
        // where mb.departement_id  = '" . $dept . "'  ");

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

    public function sisaBudgetDikurangiActual($id)
    {
        $query = $this->db->query("SELECT id_budget ,  budget as budget_input  ,
        if((SELECT SUM(nilai_budget) FROM master_planning_budget WHERE master_budget_id_budget = '" . $id . "' ) 
         is NULL, 0,(SELECT SUM(nilai_budget) FROM master_planning_budget WHERE master_budget_id_budget = '" . $id . "' )) as budget_planning ,
        (SELECT ( budget_input - budget_planning  ) ) as budget
        FROM master_budget mb 
        WHERE id_budget  = '" . $id . "' ");
        return $query;
    }


    public function getTotalBelanjaRaimbusment($id)
    {
        $query = $this->db->query("SELECT tjp.id , tjp.remarks ,
        (SELECT sum(tdjp.ammount) FROM trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id  = tjp.id  ) as total
        from transaksi_jenis_pembayaran tjp 
        where request_code = '" . $id . "' ");
        return $query;
    }

    public function PlantBudgetDepartementPerBulan($dept, $tahun, $bulan, $kode)
    {
        $query = $this->db->query("SELECT mpb.id_planing  , mb.kode_budget ,  mb.tahun ,mpb.bulan , mpb.nilai_budget  as budget_actual FROM master_budget mb  
        INNER JOIN master_planning_budget mpb  on mpb.master_budget_id_budget  = mb.id_budget
        WHERE mb.tahun  = '" . $tahun . "' and mpb.bulan = '" . $bulan . "' and mb.departement_id  = '" . $dept . "'  
        and mb.kode_budget  = '" . $kode . "' and mb.approve_fin = 1 ");
        return $query;
    }

    public function getActualPlantBudgetBulanan($id)
    {
        $query = $this->db->query("SELECT mpb.id_planing  ,  mpb.bulan , mpb.nilai_budget as plan , sum(tdjp.ammount) as terpakai ,
        (select sum(plan) -  sum(tdjp.ammount) ) as budget_actual
        from  master_budget mb  
        inner join master_planning_budget mpb  on mpb.master_budget_id_budget  = mb.id_budget 
        inner join transaksi_jenis_pembayaran tjp on tjp.master_planning_budget_id_planing = mpb.id_planing 
        inner join trans_detail_jenis_pembayaran tdjp  on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where mpb.id_planing  = '" . $id . "' and mb.approve_fin = 1 and tjp.approve_fin = 1 ")->row();
        return $query;
    }

    public function daftarActualActivity($dept_id,  $col)
    {
        $where = "";
        if ($col == "spv") {
            $where .= 'tjp.approve_spv = 0 ';
        } else  if ($col == "mgr") {
            $where .= 'tjp.approve_spv = 1 and  (tjp.approve_mgr = 0 or tjp.approve_mgr = 2) ';
        } else if ($col == "bc") {
            $where .= 'tjp.approve_mgr = 1 and (tjp.approve_acc = 0 or tjp.approve_acc = 2 ) ';
        } else if ($col == "gm") {
            $where .= 'tjp.approve_acc = 1 and (tjp.approve_gm = 0  or tjp.approve_gm = 2) ';
        } else if ($col == "fin") {
            $where .= 'tjp.approve_gm = 1  ';
        }
        $co = "tjp." . $col;
        $query = $this->db->query("SELECT mb.kode_budget ,  tjp.id as id_trans  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement , tjp.status_retur ,
         (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id ) as total   , tjp.ket ,
        tjp.approve_mgr , tjp.approve_fin , tjp.approve_acc  , tjp.approve_gm  , tjp.lampiran_1, tjp.lampiran_2, tjp.lampiran_3  , tjp.tanggal_request  , ma.nama_lengkap , ma.nik , tjp.payment_close as pcl  
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_planning_budget mpb on mpb.id_planing = tjp.master_planning_budget_id_planing
        left join master_budget mb on mb.id_budget = mpb.master_budget_id_budget 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join master_akun ma on ma.nik = tjp.created_by 
        where tjp.master_departement_id  = $dept_id and  $where ");
        return $query;
    }

    public function daftarRaimbusment($dept_id)
    {
        $query = $this->db->query("SELECT tjp.tanggal_request ,tjp.request_code , tdjp.particullar ,tdjp.ammount , tjp.remarks FROM transaksi_jenis_pembayaran tjp 
        LEFT JOIN trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id
        WHERE tjp.master_departement_id  = '" . $dept_id . "' ");
        return $query;
    }

    // request budget
    public function list_request($col, $dept, $app)
    {
        $where = "";
        if ($app == 'spv') {
            $where .= "trtb.approve_spv  = 0 or trtb.approve_spv = 2 ";
        } else if ($app == 'mgr') {
            $where .= "trtb.approve_spv  = 1 AND  trtb.approve_mgr = 0 or trtb.approve_mgr = 2  ";
        } else if ($app == 'mgr2') {
            $where .= "trtb.approve_mgr  = 1 AND  trtb.approve_mgr_2 = 0 or trtb.approve_mgr_2 = 2  ";
        } else if ($app == 'bc') {
            $where .= "trtb.approve_mgr_2  = 1 AND trtb.approve_bc = 0 or trtb.approve_bc = 2 ";
        } else if ($app == 'gm') {
            $where .= "trtb.approve_bc  = 1 AND trtb.approve_gm = 0 or trtb.approve_gm = 2 ";
        } else if ($app == 'fin') {
            $where .= "trtb.approve_gm  = 1 AND trtb.approve_fin = 0 or trtb.approve_fin = 2 or trtb.approve_fin = 1  ";
        }
        $col = "trtb." . $col;
        $query =  $this->db->query("SELECT  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  ,trtb.keperluan 
        from  transaksi_request_tambah_budget trtb 
        inner join master_planning_budget mpb  on mpb.id_planing  = trtb.master_planning_budget_id_planing 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        where trtb.master_departement_id  = '" . $dept . "'  and $where  ");
        return $query;
    }
    // 



    // dashboard
    public function totalPlaningBudget($dept)
    {
        $year = date('Y');
        $query = $this->db->query("SELECT sum(mb.budget) as nilai_budget , md.nama_departement  from master_budget mb 
        left join master_departement md  on md.id  = mb.departement_id 
        where mb.tahun = $year and mb.approve_fin  = 1  and md.id = '" . $dept . "' ");
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->nilai_budget;
        } else {
            return 0;
        }
    }


    public function totalActualBudget($dept)
    {
        $year = date('Y');
        $query = $this->db->query("SELECT mb.budget  ,
        (select sum(ammount) )as total ,
        (select (mb.budget - sum(ammount) ) ) as sisa
        from master_planning_budget mpb 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        inner join transaksi_jenis_pembayaran tjp  on tjp.master_planning_budget_id_planing = mpb.id_planing 
        inner join trans_detail_jenis_pembayaran tdjp  on tjp.id  = tdjp.transaksi_jenis_pembayaran_id 
        inner join master_departement md  on md.id  = tjp.master_departement_id 
        where mb.departement_id  = '" . $dept . "' and tjp.approve_fin  = 1 and mb.tahun  = '" . $year . "'
       group by md.id");
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->total;
        } else {
            return 0;
        }
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
        $query = $this->db->query("SELECT tjp.id, tjp.tanggal_request  , concat('Rp. ',format(tdjp.ammount,0)) as ammount  , tdjp.particullar  , tjp.remarks  , tjp.request_code , tjp.status_retur from transaksi_jenis_pembayaran tjp 
        inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id 
        where tjp.master_departement_id = '" . $dept . "' and tjp.tanggal_request  between  '" . $start . "' and '" . $end . "' and tjp.master_jenis_transaksi_id  = '" . $jenis . "' and tjp.approve_fin = 1   ");
        return $query;
    }
    // 

    // 
    public function lisTertanda($level)
    {

        $query = $this->db->query("SELECT ma.nik ,ma.nama_lengkap , ml.`level`  , ml.kode_level , mt.file  from master_tertanda mt 
        inner join master_akun ma on ma.nik = mt.master_akun_nik 
        inner join master_level ml  on ml.id  = ma.`level` 
        where ml.kode_level  = '" . $level . "'");
        return $query;
    }

    public function lisTertandaFinance($stat)
    {
        $query = $this->db->query("SELECT ma.nik ,ma.nama_lengkap , ml.`level`  , ml.kode_level , mt.file  from master_tertanda mt 
        inner join master_akun ma on ma.nik = mt.master_akun_nik 
        inner join master_level ml  on ml.id  = ma.`level` 
        where ml.kode_level  = 'FIN' and ma.master_bayar_id='" . $stat . "' ");
        return $query;
    }

    // list retur panjar
    public function returPanjar($dept)
    {
        $query = $this->db->query("SELECT tr.nilai_awal , tr.nilai_retur , tr.keterangan , tjp.request_code , tjp.status_retur  from transaksi_retur tr  
        inner join transaksi_jenis_pembayaran tjp on tjp.id  = tr.transaksi_jenis_pembayaran_id 
        where tr.master_departement_id  = '" . $dept . "' ");
        return $query;
    }


    // list platnt voucher
    public function daftarPlantVoucher($dept)
    {
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 ,
        tpv.lampiran_2  , tpv.lampiran_3, ma.nama_lengkap  as nama , mjt.jenis_transaksi,
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_akun ma on ma.nik  = tpv.created_by  
        WHERE md.id = '" . $dept . "'
        ");
        return $query;
    }

    public function historiVoucherReport($dept)
    {
        $query = $this->db->query("SELECT tpv.id , md.nama_departement , tpv.remarks  , tpv.request_code , tpv.tanggal_request as tanggal , tpv.lampiran_1 ,
        tpv.lampiran_2  , tpv.lampiran_3, ma.nama_lengkap  as nama , 
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher , tpv.approve_lapor_mgr, tpv.approve_fin ,
        tpv.approve_lapor_bc, tpv.approve_lapor_gm, tpv.approve_lapor_fin , tpv.plant_sebelumnya
        from transaksi_plant_voucher tpv 
        inner join master_jenis_transaksi mjt on mjt.id = tpv.master_jenis_transaksi_id 
        inner join master_departement md on md.id = tpv.master_departement_id 
        inner join master_akun ma on ma.nik  = tpv.created_by  
        WHERE md.id = '" . $dept . "' and stat_lapor = 1 
        ");
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


    public function pemakaianBulanan($id, $bulan)
    {
        $d = "2023-" . $bulan;
        $query = $this->db->query("SELECT mb.kode_budget , mpb.bulan  , mpb.id_planing  , 
        (select sum(tdjp.ammount) from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id = tjp.id  )as total
        from transaksi_jenis_pembayaran tjp 
        inner join master_planning_budget mpb on mpb.id_planing  = tjp.master_planning_budget_id_planing 
        inner join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget 
        where date_format(tjp.tanggal_request , '%Y-%m') = '" . $d . "' and mb.id_budget  = '" . $id . "'
        and tjp.approve_fin  = 1 ");
        $d = array();
        foreach ($query->result() as $nm) {
            $d[] = $nm->total;
        }
        return array_sum($d);
        // var_dump($query->result());
        // return $query->result();
    }



    public function sisaBudgetTahunan($kode)
    {
        $kode = $this->db->query("SELECT kode_budget , budget as plant_budget ,
        ifnull((select sum(ammount) from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id  = tjp.id ),0)
        as actual_budget , (select (budget - actual_budget)) as sisa_budget
        from master_budget mb 
        inner join master_planning_budget mpb on mpb.master_budget_id_budget  = mb.id_budget 
        left join transaksi_jenis_pembayaran tjp on tjp.master_planning_budget_id_planing = mpb.id_planing 
        where departement_id = '" . $this->session->userdata("departement_id") . "'
        and mb.tahun = '" . date('Y') . "' and mb.approve_fin  = 1 and tjp.approve_fin = 1 
        and mb.kode_budget = '" . $kode . "'
        ")->result();

        $budget = array();
        foreach ($kode as $k) {
            $budget[] = $k->actual_budget;
        }
        return array_sum($budget);
    }
}
