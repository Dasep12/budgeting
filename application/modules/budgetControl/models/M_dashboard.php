<?php


class M_dashboard extends CI_Model
{

    // dashboard
    public function getDept($nik)
    {
        $data = array();
        $query = $this->db->query("SELECT md.nama_departement FROM 
        master_bawahan_depthead  mbd
        LEFT JOIN master_akun ma on ma.nik = mbd.master_akun_nik
        LEFT JOIN master_departement md on md.id = mbd.master_departement_id
        WHERE  mbd.master_akun_nik  = '" . $nik . "'
         ");
        foreach ($query->result_array() as $key => $rso) {
            $data[] = $rso['nama_departement'];
        }

        return json_encode($data, true);
    }
    // 

    public function queryDepartement()
    {
        $query = $this->db->query("SELECT md.nama_departement , md.id FROM 
        master_bawahan_depthead  mbd
        LEFT JOIN master_akun ma on ma.nik = mbd.master_akun_nik
        LEFT JOIN master_departement md on md.id = mbd.master_departement_id
         ");
        return $query;
    }

    public function getTotalPlaning($tahun)
    {
        $query = $this->db->query("SELECT md.nama_departement  ,
        ifnull((select sum(mb.budget) from master_budget mb where mb.departement_id  = md.id 
        and mb.approve_fin  = 1  and mb.tahun  = '" . $tahun . "'
        ),0)as total
        from master_departement md ");
        $data = array();
        foreach ($query->result_array() as $key => $rso) {
            $data[] = $rso['total'];
        }

        return json_encode($data, true);
    }
    public function getTotalActual($tahun)
    {
        $query = $this->db->query("SELECT md.nama_departement  ,
        ifnull((select sum(tr.ammount) from trans_detail_jenis_pembayaran tr 
        inner join transaksi_jenis_pembayaran tjp on tjp.master_departement_id = md.id
        inner join master_planning_budget mpb  on tjp.master_planning_budget_id_planing = mpb.id_planing 
        inner join master_budget mb  on mb.id_budget  = mpb.master_budget_id_budget 
        where  
        tr.transaksi_jenis_pembayaran_id  = tjp.id 
        and tjp.approve_fin  = 1 and mb.tahun  = '" . $tahun . "'
        ),0)as total
        from master_departement md
         ");
        $data = array();
        foreach ($query->result_array() as $key => $rso) {
            $data[] = $rso['total'];
        }

        return json_encode($data, true);
    }

    public function getDetailPerDepartement($year, $dept)
    {
        $query =  $this->db->query("SELECT kode_budget , budget as plant_budget ,
        ifnull((select sum(ammount) from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id  = tjp.id ),0)
        as actual_budget , (select (budget - actual_budget)) as sisa_budget
        from master_budget mb 
        inner join master_planning_budget mpb on mpb.master_budget_id_budget  = mb.id_budget 
        left join transaksi_jenis_pembayaran tjp on tjp.master_planning_budget_id_planing = mpb.id_planing 
        where departement_id = '" . $dept . "'
        and mb.tahun = '" . $year . "' and mb.approve_fin  = 1
        group by mb.kode_budget 
        ");
        return $query;
    }
}
