<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_accounting', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_approve()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'daftar'    => $this->model->daftarApprove(1)
        ];
        $this->template->load('template_acc', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");

        $data = [
            'status'            => $kode,
            'ket'               => $kode == 1 ? 'accept accounting' : 'reject accounting',
            'date_approved_acc' => date('Y-m-d H:i:s'),
            'approve_acc'      => $kode,
            'approve_acc_user' => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'budget telah di setujui' : 'budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('accounting/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('accounting/Approved/list_approve');
        }
    }
}
