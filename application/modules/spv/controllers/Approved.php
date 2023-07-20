<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_supervisor', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'SPV') {
            redirect('Login');
        }
    }

    public function list_approve()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->daftarApprove(0, $this->session->userdata("departement_id"), $sess),
            'proces'    => $this->model->daftarApprove(1, $this->session->userdata("departement_id"), $sess),
        ];
        $this->template->load('template_supervisor', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'status'            => $kode,
            'ket'               => $kode == 1 ? 'accept supervisor' : 'reject supervisor',
            'date_approved_spv' => date('Y-m-d H:i:s'),
            'approve_spv'       => $kode,
            'approve_spv_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "budget telah di setujui, silahkan konfirmasi ke pihak Budget Controller");
            redirect('spv/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('spv/Approved/list_approve');
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data['data']    = $this->model->detailBudget($id);
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
                'ket'               => 'accept supervisor',
                'date_approved_spv' => date('Y-m-d H:i:s'),
                'approve_spv'       => 1,
                'approve_spv_user'  => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('spv/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('spv/Approved/list_approve');
        }
    }


    public function multiReject()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 1,
                'ket'               => 'reject supervisor',
                'date_approved_spv' => date('Y-m-d H:i:s'),
                'approve_spv'       => 2,
                'approve_spv_user'  => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget di tolak,silahkan konfirmasi ke departement terkait');
            redirect('spv/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('spv/Approved/list_approve');
        }
    }
}
