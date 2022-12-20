<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_bc', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'bc') {
            redirect('Login');
        }
    }

    public function list_approve()
    {
        $data = [
            'uri'        => $this->uri->segment(2),
            'daftar'     => $this->model->daftarApprove(0),
            'selesai'    => $this->model->daftarApprove(1),
        ];
        $this->template->load('template_bc', 'list_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'status'            => $kode,
            'ket'               => $kode == 1 ? 'accept budget controller' : 'reject budget controller',
            'date_approved_bc' => date('Y-m-d H:i:s'),
            'approve_bc'       => $kode,
            'approve_bc_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'budget telah di setujui' : 'budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "budget di tolak");
            redirect('budgetControl/Approved/list_approve');
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data['data']  = $this->model->detailBudget($id);
        $this->load->view("detail_budget", $data);
    }

    public function editBudget()
    {
        $budget_lama = $this->input->post("budget_awal_real");
        $budget_baru = $this->input->post("budget_baru_real");
        $id          = $this->input->post("id_budget_update");

        $updateData = [
            'budget'   => $budget_baru,
        ];

        $this->db->where("id_budget", $id);
        $this->db->update("master_budget", $updateData);
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $dataInput = [
                'master_budget_id_budget'   => $id,
                'budget_sebelumnya'         => $budget_lama,
                'budget_update'             => $budget_baru,
                'updated_at'                => date('Y-m-d H:i:s'),
                'updated_by'                => $this->session->userdata("nik")
            ];
            $this->db->insert("transaksi_edit_budget", $dataInput);
            $this->session->set_flashdata("ok", "Budget di perbaharui ");
            redirect('accounting/Approved/list_approve');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "Gagal  , terjadi kesalahan");
            redirect('accounting/Approved/list_approve');
        }
    }
}
