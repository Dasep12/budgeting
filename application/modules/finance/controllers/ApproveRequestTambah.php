<?php


class ApproveRequestTambah extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'FIN') {
            redirect('Login');
        }
    }

    public function list_approve_req()
    {
        $data = [
            'uri'            => $this->uri->segment(2),
            'menunggu'       => $this->model->list_request('fin', 0),
            'selesai'        => $this->model->list_request('fin', 1)
        ];
        $this->template->load('template_fin', 'list_approved_request_tambah', $data);
    }

    public function approve()
    {
        $id         = $this->input->get("id");
        $kode       = $this->input->get("kode");
        $id_budget  = $this->input->get("budget_id");
        $id_plant   = $this->input->get("plant_id");
        $n          = $this->input->get("n");
        $data = [
            'status'                     => $kode,
            'ket'                        => $kode == 1 ? 'accept finance' : 'reject finance',
            'date_approve_fin'           => date('Y-m-d H:i:s'),
            'approve_fin'                => $kode,
            'approve_fin_user'           => $this->session->userdata("nik")
        ];

        // databudget
        $databudget = $this->db->query("SELECT id_budget , budget FROM master_budget WHERE id_budget = '" . $id_budget . "' ")->row();
        $newBudget = (int)$databudget->budget + (int)$n;
        // data planning budget
        $dataplant = $this->db->query("SELECT id_planing , nilai_budget FROM master_planning_budget WHERE id_planing = '" . $id_plant . "' ")->row();
        $newBudgetPlant = (int)$dataplant->nilai_budget + (int)$n;
        echo $newBudget . "<br>" . $newBudgetPlant;
        // 
        $update_budget = $this->model->updateData(['budget' => $newBudget], "master_budget", ['id_budget' => $id_budget]);
        // 
        $update_plant_budget = $this->model->updateData(['nilai_budget' => $newBudgetPlant], "master_planning_budget", ['id_planing' => $id_plant]);


        if ($update_budget > 0 && $update_plant_budget > 0) {
            $this->db->trans_commit();
            $update = $this->model->updateData($data, "transaksi_request_tambah_budget", ['id' => $id]);
            if ($update > 0) {
                $this->session->set_flashdata("ok", $kode == 1 ? 'penambahan budget telah di setujui' : 'penambahan budget telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
                redirect('finance/ApproveRequestTambah/list_approve_req');
            } else {
                $this->session->set_flashdata("nok", "terjadi kesalahan update");
                redirect('finance/ApproveRequestTambah/list_approve_req');
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/ApproveRequestTambah/list_approve_req');
        }
    }
}
