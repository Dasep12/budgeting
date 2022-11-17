<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_manager', 'model');
        date_default_timezone_set('Asia/Jakarta');
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
        if ($kode == 6) {
            $status = 6;
        } else {
            $status =  $kode;
        }
        $data = [
            'status'    => $status,
            'ket'       => $status == 1 ? 'accept manager' : 'reject manager',
            'date_approved_manager' => date('Y-m-d H:i:s')
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "budget telah di setujui, silahkan konfirmasi ke pihak Finnance");
            redirect('manager/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('manager/Approved/list_approve');
        }
    }
}
