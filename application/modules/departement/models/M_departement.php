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

    public function multiInsert($data, $table)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function daftarPlantBudgetDepartement($dept)
    {
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget, mb.budget ,  md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity , mb.created_at  FROM master_planning_budget  mpb
        left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        inner join master_departement md on mb.departement_id = md.id 
        WHERE mb.departement_id  = '" . $dept . "' group by mb.kode_budget
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
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget, mb.budget ,  md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity , mb.created_at  , mb.improvment , mb.pic  , mjb.jenis_budget FROM master_planning_budget  mpb
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
        and mb.kode_budget  = '" . $kode . "' and mb.approve_bc = 1 ");
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
        where mpb.id_planing  = '" . $id . "' ")->row();
        return $query;
    }

    public function daftarActualActivity($dept_id,  $col, $stat)
    {
        // $query = $this->db->query("SELECT mjb.jenis_budget ,   mb.kode_budget , mb.tahun , md.nama_departement  , tab.tanggal_transaksi  , tab.nilai_budget , tab.activity  , tab.created_at 
        // FROM transaksi_actual_budget tab 
        //  LEFT JOIN master_planning_budget mpb on mpb.id_planing  = tab.master_planning_budget_id_planing 
        //  LEFT JOIN master_budget mb on mb.id_budget  = mpb.master_budget_id_budget 
        //  LEFt JOIN master_jenis_budget mjb  on mb.master_jenis_budget_id  = mjb.id
        //  left JOIN master_departement md  on mb.departement_id  = md.id  WHERE mb.departement_id  = '" . $id . "' ");

        $co = "tjp." . $col;
        $query = $this->db->query("SELECT tjp.id as id_trans  ,  tjp.remarks , tjp.request_code , mjt.jenis_transaksi  ,md.nama_departement  , tjp.ket ,
        (select(tdjp.ammount)) as total   ,
        tjp.approve_mgr  , tjp.lampiran  , tjp.tanggal_request 
        from transaksi_jenis_pembayaran tjp 
        left join master_jenis_transaksi mjt on tjp.master_jenis_transaksi_id = mjt.id 
        left join master_departement md  on md.id  = tjp.master_departement_id 
        left join trans_detail_jenis_pembayaran tdjp  on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where tjp.master_departement_id  = $dept_id and $co  = $stat  ");
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
        if ($app == 'mgr') {
            $where .= "trtb.approve_mgr  = 0 or trtb.approve_mgr = 2";
        } else if ($app == 'bc') {
            $where .= "trtb.approve_mgr  = 1 AND trtb.approve_bc = 0 or trtb.approve_bc = 2 ";
        } else if ($app == 'gm') {
            $where .= "trtb.approve_bc  = 1 AND trtb.approve_gm = 0 or trtb.approve_gm = 2 ";
        } else if ($app == 'fin') {
            $where .= "trtb.approve_gm  = 1 AND trtb.approve_fin = 0 or trtb.approve_fin = 2 or trtb.approve_fin = 1  ";
        }
        $col = "trtb." . $col;
        $query =  $this->db->query("SELECT  trtb.budget_sebelumnya  , trtb.budget_request  , trtb.ket , trtb.created_at as tanggal  , mpb.bulan  , mb.tahun  
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
        where mb.departement_id  = '" . $dept . "' and tjp.approve_gm  = 1 and mb.tahun  = 2022
        group by mpb.master_budget_id_budget  ");
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->total;
        } else {
            return 0;
        }
    }
    // 
}
