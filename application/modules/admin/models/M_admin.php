<?php


class M_admin extends CI_Model
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

    public function updateData($data, $table, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function ambilData($table, $where)
    {
        return  $this->db->get_where($table, $where);
    }

    // list tertanda
    public function getTertanda()
    {
        $query = $this->db->query("SELECT mt.id , mt.type_transaksi as tipe , ma.nik ,ma.nama_lengkap , ml.`level`  , ml.kode_level , mt.file  from master_tertanda mt 
        inner join master_akun ma on ma.nik = mt.master_akun_nik 
        inner join master_level ml  on ml.id  = ma.`level` ");
        return $query;
    }

    public function daftarUser($nik)
    {
        $where = "";
        if ($nik != NULL) {
            $where .= 'ma.nik=' . $nik;
            $query = $this->db->query("SELECT ma.nik , ma.nama_lengkap  , ma.user_name  , ml.`level`  , md.nama_departement , ma.departement_id , ma.`level` , ml.`level` as dept,
            ma.master_bayar_id as tipe_bayar
             from master_akun ma 
            left join master_departement md on md.id = ma.departement_id 
            left join master_level ml on ml.id = ma.`level`  WHERE $where ");
        } else {
            $query = $this->db->query("SELECT ma.nik , ma.nama_lengkap  , ma.user_name  , ml.`level` as dept  , md.nama_departement , ma.departement_id , ma.`level` as lev , ml.`level` ,
            ma.master_bayar_id as tipe_bayar
            from master_akun ma 
            left join master_departement md on md.id = ma.departement_id 
            left join master_level ml on ml.id = ma.`level` ");
        }
        return $query;
    }
}
