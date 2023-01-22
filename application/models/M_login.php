<?php

class M_login extends CI_Model
{

    public function cek_login($user, $pwd)
    {
        // $query = $this->db->get_where("master_akun", ['user_name' => $user, 'password' => $pwd]);
        $query = $this->db->query("SELECT ma.departement_id , ma.nik , ma.nama_lengkap , ml.kode_level as level , ma.master_bayar_id as bayar_id FROM master_akun ma 
        inner join master_level ml on ml.id = ma.level 
        inner join master_bayar mb on mb.id = ma.master_bayar_id 
         WHERE user_name ='" . $user . "' AND password='" . $pwd . "' ");
        return $query;
    }
}
