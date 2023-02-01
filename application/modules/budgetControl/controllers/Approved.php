<?php


class Approved extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_bc', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'BC') {
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
        $data['detail']  = $this->model->DetaildaftarPlantBudgetDepartement($id)->row();
        $this->load->view("detail_budget", $data);
    }


    public function getBudgetBulanan(Type $var = null)
    {
        $bulan = $this->input->get("bulan");
        $idplant = $this->input->get("id_plant");
        $query = $this->db->query("SELECT nilai_budget , id_planing FROM master_planning_budget WHERE master_budget_id_budget='" . $idplant . "' and bulan='" . $bulan . "' ");
        if ($query->num_rows() > 0) {
            echo json_encode($query->row());
        } else {
            echo 0;
        }
    }

    public function editBudget()
    {
        $budget_baru = $this->input->post("budget_baru_real");
        $id          = $this->input->post("id_budget_update");
        $idplant     = $this->input->post("id_planing");
        $budgetBulan = $this->input->post("bulan_budget_real");

        $updateData = [
            'nilai_budget'   => $budget_baru,
        ];

        $this->db->where("id_planing", $idplant);
        $this->db->update("master_planning_budget", $updateData);
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $totalBudget = $this->db->query("SELECT sum(nilai_budget)as total FROM master_planning_budget WHERE master_budget_id_budget='" . $id . "'  ")->row();
            $this->model->updateData(['budget' => $totalBudget->total], 'master_budget', ['id_budget' => $id]);

            $dataInput = [
                'master_budget_id_budget'   => $id,
                'master_planing_id'         => $idplant,
                'budget_sebelumnya'         => $budgetBulan,
                'budget_update'             => $budget_baru,
                'updated_at'                => date('Y-m-d H:i:s'),
                'updated_by'                => $this->session->userdata("nik")
            ];
            $this->db->insert("transaksi_edit_budget", $dataInput);
            $this->session->set_flashdata("ok", "Budget di perbaharui ");
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "Gagal  , terjadi kesalahan");
            redirect('budgetControl/Approved/list_approve');
        }
    }

    public function multiApprove()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 1,
                'ket'               => 'accept budget controller',
                'date_approved_bc'  => date('Y-m-d H:i:s'),
                'approve_bc'        => 1,
                'approve_bc_user'   => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('budgetControl/Approved/list_approve');
        }
    }

    public function multiReject()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 2,
                'ket'               => 'reject budget controller',
                'date_approved_bc'  => date('Y-m-d H:i:s'),
                'approve_bc'        => 2,
                'approve_bc_user'   => $this->session->userdata("nik"),
                'id_budget'         => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('master_budget', $data, 'id_budget');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget di tolak,silahkan konfirmasi ke departement terkait');
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('budgetControl/Approved/list_approve');
        }
    }


    public function delete()
    {
        $id = $this->input->get("id_budget");
        $del = $this->model->delete(['master_budget_id_budget' => $id], "master_planning_budget");
        if ($del > 0) {
            $this->db->trans_commit();
            $this->model->delete(['id_budget' => $id], "master_budget");
            $this->session->set_flashdata("ok", 'plant budget di hapus');
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('budgetControl/Approved/list_approve');
        }
    }

    public function multiDelete()
    {
        $id = $this->input->post("multi[]");
        $n = 0;
        for ($i = 0; $i < count($id); $i++) {
            $del = $this->model->delete(['master_budget_id_budget' => $id[$i]], "master_planning_budget");
            if ($del > 0) {
                $this->db->trans_commit();
                $this->model->delete(['id_budget' => $id[$i]], "master_budget");
                $n++;
            } else {
                $this->db->trans_rollback();
                $n;
            }
        }

        if ($n == count($id)) {
            $this->session->set_flashdata("ok", 'plant budget di hapus');
            redirect('budgetControl/Approved/list_approve');
        } else {
            $this->session->set_flashdata("nok", "data tidak terhapus semua");
            redirect('budgetControl/Approved/list_approve');
        }
    }
}
