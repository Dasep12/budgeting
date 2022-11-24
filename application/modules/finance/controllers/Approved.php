<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_approve()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'daftar'    => $this->model->daftarApprove(1)
        ];
        $this->template->load('template_fin', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'status'    => $kode,
            'ket'       => $kode == 2 ? 'accept finance' : 'reject finance',
            'date_approved_finance' => date('Y-m-d H:i:s'),
            'approve_fin'           => $kode,
            'approve_fin_user'      => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'budget telah di setujui' : 'budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('finance/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('finance/Approved/list_approve');
        }
    }
}
