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
        $role = $this->session->userdata("level");
        if ($role != 'GM') {
            redirect('Login');
        }
    }

    public function list_approve()
    {
        $data = [
            'uri'        => $this->uri->segment(2),
            'daftar'     => $this->model->daftarApprove(0),
            'selesai'    => $this->model->daftarApprove(1)
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
        $data['detail']  = $this->model->DetaildaftarPlantBudgetDepartement($id)->row();
        $this->load->view("detail_budget", $data);
    }

    public function multiApprove()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 1,
                'ket'               => 'accept general manager',
                'date_approved_gm'  => date('Y-m-d H:i:s'),
                'approve_gm'        => 1,
                'approve_gm_user'   => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('gm/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('gm/Approved/list_approve');
        }
    }

    public function multiReject()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 2,
                'ket'               => 'reject general manager',
                'date_approved_gm'  => date('Y-m-d H:i:s'),
                'approve_gm'        => 2,
                'approve_gm_user'   => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget di tolak,silahkan konfirmasi ke departement terkait');
            redirect('gm/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('gm/Approved/list_approve');
        }
    }
}
