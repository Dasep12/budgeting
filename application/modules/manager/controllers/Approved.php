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
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->daftarApprove(0, $this->session->userdata("departement_id")),
            'proces'    => $this->model->daftarApprove(1, $this->session->userdata("departement_id")),
        ];
        $this->template->load('template_manager', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'status'            => $kode,
            'ket'               => $kode == 1 ? 'accept manager' : 'reject manager',
            'date_approved_mgr' => date('Y-m-d H:i:s'),
            'approve_mgr'       => $kode,
            'approve_mgr_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "budget telah di setujui, silahkan konfirmasi ke pihak Budget Controller");
            redirect('manager/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('manager/Approved/list_approve');
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data['data']  = $this->model->detailBudget($id);
        $this->load->view("detail_budget", $data);
    }
}
