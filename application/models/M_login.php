<?php

class M_login extends CI_Model
{

    public function cek_login($user, $pwd)
    {
        $query = $this->db->get_where("master_akun", ['user_name' => $user, 'password' => $pwd]);
        return $query;
    }
}
