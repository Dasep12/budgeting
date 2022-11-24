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
        // $query = $this->db->query("SELECT mb.kode_budget, md.nama_departement , mb.tahun , mpb.bulan, mpb.nilai_budget ,mpb.activity  FROM master_planning_budget  mpb
        // left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget  
        // inner join master_departement md on mb.departement_id = md.id 
        // WHERE mb.departement_id  = '" . $dept . "' ");
        $query = $this->db->query("SELECT mb.id_budget , mb.kode_budget , mb.tahun , md.nama_departement  , mpb.activity  ,  sum(mpb.nilai_budget) as total , mpb.kode_plant_activity as kp
        from master_budget mb 
        left join master_planning_budget mpb on mb.id_budget  = mpb.master_budget_id_budget
        left join master_departement md  on md.id =  mb.departement_id 
        where mb.departement_id  = '" . $dept . "'
        group by mpb.activity  ");

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
        and mb.kode_budget  = '" . $kode . "' ");
        return $query;
    }

    public function getActualPlantBudgetBulanan($id)
    {
        $query = $this->db->query("SELECT mpb.id_planing  , mb.kode_budget , mpb.bulan , mpb.nilai_budget ,
            (SELECT  ( mpb.nilai_budget - SUM(tab.nilai_budget)  )  ) as budget_actual
                 FROM transaksi_actual_budget tab  
                 LEFT JOIN master_planning_budget mpb on mpb.id_planing  = tab.master_planning_budget_id_planing 
                 LEFT JOIN master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
             WHERE tab.master_planning_budget_id_planing  = '" . $id . "' ")->row();
        return $query;
    }

    public function daftarActualActivity($id)
    {
        $query = $this->db->query("SELECT mjb.jenis_budget ,   mb.kode_budget , mb.tahun , md.nama_departement  , tab.tanggal_transaksi  , tab.nilai_budget , tab.activity  , tab.created_at 
        FROM transaksi_actual_budget tab 
         LEFT JOIN master_planning_budget mpb on mpb.id_planing  = tab.master_planning_budget_id_planing 
         LEFT JOIN master_budget mb on mb.id_budget  = mpb.master_budget_id_budget 
         LEFt JOIN master_jenis_budget mjb  on mb.master_jenis_budget_id  = mjb.id
         left JOIN master_departement md  on mb.departement_id  = md.id  WHERE mb.departement_id  = '" . $id . "' ");
        return $query;
    }

    public function daftarRaimbusment($dept_id)
    {
        $query = $this->db->query("SELECT tjp.tanggal_request ,tjp.request_code , tdjp.particullar ,tdjp.ammount , tjp.remarks FROM transaksi_jenis_pembayaran tjp 
        LEFT JOIN trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id = tjp.id
        WHERE tjp.master_departement_id  = '" . $dept_id . "' ");
        return $query;
    }
}
