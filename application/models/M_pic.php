<?php


class M_pic extends CI_Model
{
    public function show($table)
    {
        return $this->db->get($table);
    }

    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    public function delete($data, $table)
    {
        $this->db->where($data);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function update($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }


    public function lokasi()
    {
        $query = $this->db->query("SELECT ml.id as id , ml.nama_lokasi , ml.master_plant_id ,ml.latitude , ml.longitude ,ml.status , pl.nama_plant FROM master_lokasi ml , master_plant pl WHERE ml.master_plant_id = pl.id ");
        return $query;
    }

    public function user()
    {
        $query = $this->db->query("SELECT mu.id as id , mu.nama_user , mu.master_plant_id ,mu.npk , mu.password , mu.status , pl.nama_plant , IF(mu.level = 0 , 'PIC', 'SECURITY') as level FROM master_user mu , master_plant pl WHERE mu.master_plant_id = pl.id ");
        return $query;
    }

    public function lokasi_patroli()
    {
        $query =  $this->db->query("SELECT tp.id as id_setting , mp.nama_plant , ml.nama_lokasi , tp.master_lokasi_id , tp.status FROM transaksi_setting_patroli tp , master_plant mp , master_lokasi ml WHERE tp.master_lokasi_id= ml.id AND mp.id = ml.master_plant_id   ");
        return $query;
    }
}
