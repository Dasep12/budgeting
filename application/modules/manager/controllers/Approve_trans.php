<?php


class Approve_trans extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_manager', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_approve_trans()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->listTransaksi($this->session->userdata("departement_id"), 0)
        ];
        $this->template->load('template_manager', 'list_approved_trans', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id");
        $kode = $this->input->get("kode");
        $data = [
            'status_approved'            => $kode,
            'ket'               => $kode == 1 ? 'accept manager' : 'reject manager',
            'date_approve_mgr' => date('Y-m-d H:i:s'),
            'approve_mgr'       => $kode,
            'approve_mgr_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_jenis_pembayaran", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'budget telah di setujui' : 'budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('manager/Approve_trans/list_approve_trans');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('manager/Approve_trans/list_approve_trans');
        }
    }

    public function viewDetailRaimbes()
    {
        $id = $this->input->post("id");
        $data = [
            'raimbus'   => $this->model->ambilData('trans_detail_jenis_pembayaran', ['transaksi_jenis_pembayaran_id' => $id])
        ];
        $this->load->view("detail_approved_trans", $data);
    }

    public function histori_approve_trans()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->ambilData("transaksi_jenis_pembayaran", ['approve_mgr  !=' => 0])
        ];
        $this->template->load('template_manager', 'histori_raimbusment_approved', $data);
    }
}
