<?php


class M_dashboard extends CI_Model
{

    // 
    public function ambilData($nik)
    {
        $data = array();
        $query = $this->db->query("SELECT mbd.nama_departement FROM 
        master_akun ma 
        left join master_departement mbd on ma.departement_id = mbd.id
        WHERE  ma.nik  = '" . $nik . "'
         ");
        foreach ($query->result_array() as $key => $rso) {
            $data[] = $rso['nama_departement'];
        }

        return json_encode($data, true);
    }
    // 
    // dashboard
    // public function getDept($nik)
    // {
    //     $data = array();
    //     $query = $this->db->query("SELECT md.nama_departement FROM 
    //     master_bawahan_depthead  mbd
    //     LEFT JOIN master_akun ma on ma.nik = mbd.master_akun_nik
    //     LEFT JOIN master_departement md on md.id = mbd.master_departement_id
    //     WHERE  mbd.master_akun_nik  = '" . $nik . "'
    //      ");
    //     foreach ($query->result_array() as $key => $rso) {
    //         $data[] = $rso['nama_departement'];
    //     }

    //     return json_encode($data, true);
    // }
    // 

    public function getTotalPlaning($tahun, $id)
    {
        $query = $this->db->query("SELECT md.nama_departement  ,
        ifnull((select sum(mb.budget) from master_budget mb where mb.departement_id  = md.id 
        and mb.approve_fin  = 1  and mb.tahun  = '" . $tahun . "'
        ),0)as total
        from master_departement md 
        inner join master_akun ma on ma.departement_id = md.id
        where ma.departement_id = '" . $id . "'  group by md.id  ");
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
}
