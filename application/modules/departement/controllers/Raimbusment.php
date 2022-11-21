<?php


class Raimbusment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function form_raimbusment()
    {
        $code_dept = $this->db->query(" SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();
        $data = [
            'uri'       => $this->uri->segment(2),
            'code_dept'     => $code_dept->code . 'REQ/RAIMB' . rand(13, 15) . '/' . rand(10, 30),
            'raimbus'       => $this->model->daftarRaimbusment($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'form_raimbusment', $data);
    }

    public function input()
    {
        $ammount = $this->input->post("ammount");
        $particullars = $this->input->post("particullar");
        $part = array();

        $data = [
            'master_departement_id'     => $this->session->userdata("departement_id"),
            'type'                      => '01',
            'request_code'              => $this->input->post("request_code"),
            'tanggal_request'           => $this->input->post("tanggal"),
            'remarks'                   => $this->input->post("remarks"),
            'status_approved'           => 0,
            'ket'                       => "menunggu approved manager",
            'created_at'                => date('Y-m-d H:i:s'),
            'created_by'                => $this->session->userdata("nik")
        ];

        $this->db->insert("transaksi_jenis_pembayaran", $data);
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $id = $this->db->insert_id();
            for ($i = 0; $i < count($ammount); $i++) {
                $arr = [
                    'ammount'                          => $ammount[$i],
                    'particullar'                     => $particullars[$i],
                    'transaksi_jenis_pembayaran_id'    => $id
                ];
                array_push($part, $arr);
            }
            $this->db->insert_batch("trans_detail_jenis_pembayaran", $part);
            $this->session->set_flashdata("ok", "Raimbusment di simpan , menunggu approval");
            redirect('departement/Raimbusment/form_raimbusment');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "Gagal  , terjadi kesalahan");
            redirect('departement/Raimbusment/form_raimbusment');
        }
    }
}
