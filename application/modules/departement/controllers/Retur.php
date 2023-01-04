<?php

class Retur extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $this->load->helper('convertbulan');
        date_default_timezone_set('Asia/Jakarta');

        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function historiPanjer(Type $var = null)
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'retur'         => $this->model->returPanjar($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'histori_retur_panjar', $data);
    }

    public function form_input()
    {

        $idPanjar = $this->model->ambilData("master_jenis_transaksi", ['jenis_transaksi' => 'PANJAR'])->row();

        $data = [
            'list'          => $this->db->query("SELECT tjp.request_code , tjp.id  from transaksi_jenis_pembayaran tjp 
            inner join master_jenis_transaksi mjt on mjt.id  = tjp.master_jenis_transaksi_id 
            where tjp.status_retur = 0 AND  tjp.master_jenis_transaksi_id  = '" . $idPanjar->id . "'  and tjp.approve_fin  = 1 "),
            'uri'           => $this->uri->segment(2),
        ];
        $this->template->load('template_departement', 'retur_panjer', $data);
    }

    public function getDataTransaksi()
    {
        $kode = $this->input->get("id");
        $query = $this->db->query("SELECT   tjp.request_code ,
        sum(tdjp.ammount) as total , tjp.master_planning_budget_id_planing as plant_id , tdjp.id as detail_id_trans , tjp.id as trans_id 
        from transaksi_jenis_pembayaran tjp  
        inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where tjp.id ='" . $kode . "'  ");

        if ($query->num_rows() > 0) {
            echo json_encode($query->row());
        } else {
            echo 0;
        }
    }


    public function inputRetur()
    {
        $panjer      = $this->input->post("nilai_panjar");
        $returpanjer = $this->input->post("return_panjar");
        $iddetail    = $this->input->post("detail_idtrans");
        $idTrans     = $this->input->post("id_trans");
        $ket         = $this->input->post("keterangan");
        $total = (int)$panjer - (int) $returpanjer;
        $data = [
            'transaksi_jenis_pembayaran_id' => $idTrans,
            'keterangan'                    => $ket,
            'nilai_retur'                   => $returpanjer,
            'nilai_awal'                    => $panjer,
            'master_departement_id'         => $this->session->userdata("departement_id")
        ];

        $save = $this->model->insert("transaksi_retur", $data);
        if ($save > 0) {
            $this->db->trans_commit();
            $this->db->where(['id' => $iddetail]);
            $this->db->update("trans_detail_jenis_pembayaran", ['ammount' => $total]);
            $this->model->updateData(['status_retur' => 1], "transaksi_jenis_pembayaran", ['id' => $idTrans]);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("ok", " input retur panjar");
                redirect('departement/Retur/form_input');
            } else {
                $this->session->set_flashdata("nok", "gagal di input");
                redirect('departement/Retur/form_input');
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "gagal di input");
            redirect('departement/Retur/form_input');
        }
    }
}
