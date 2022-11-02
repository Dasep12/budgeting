<?php


class M_user extends CI_Model
{
    public function getPatroli($idPlant)
    {
        $query =  $this->db->query("SELECT ml.id as id_lokasi , tp.id as id_setting , mp.nama_plant , ml.nama_lokasi , tp.master_lokasi_id , tp.status FROM transaksi_setting_patroli tp , master_plant mp , master_lokasi ml WHERE tp.master_lokasi_id= ml.id AND mp.id = ml.master_plant_id  AND mp.id='" . $idPlant . "'  ");
        return $query;
    }
}
