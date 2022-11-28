<?php
// 1.Departement 
// 2.Manager Dept 
// 3.Finn 
// 4.Acc 
// 5.GM
// 0 di tolak

class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_gm', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_approve()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'daftar'    => $this->model->daftarApprove(1)
        ];
        $this->template->load('template_gm', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");

        $data = [
            'status'             => $kode,
            'ket'                => $kode == 1 ? 'accept general manager' : 'reject general manager',
            'date_approved_gm'   => date('Y-m-d H:i:s'),
            'approve_gm'         => $kode,
            'approve_gm_user'    => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'budget telah di setujui' : 'budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('gm/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('gm/Approved/list_approve');
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data['data']  = $this->model->detailBudget($id);
        $this->load->view("detail_budget", $data);
    }
}
