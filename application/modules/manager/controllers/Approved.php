<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_manager', 'model');
    }

    public function list_approve()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'daftar'    => $this->model->daftarApprove()
        ];
        $this->template->load('template_manager', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        if ($kode == 1) {
            $status = 1;
        } else {
            $status = 2;
        }
        $data = [
            'status'    => $status
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "Berhasil ");
            redirect('manager/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "gagal");
            redirect('manager/Approved/list_approve');
        }
    }
}
