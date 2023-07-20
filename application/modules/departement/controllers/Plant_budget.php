<?php

class Plant_budget extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function list_budget()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'plant'     => $this->model->daftarPlantBudgetDepartement($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'daftar_plant_budget_activity', $data);
    }

    public function form_input_plant(Type $var = null)
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'jenis'     => $this->model->getData("master_jenis_budget")->result()
        ];
        $this->template->load('template_departement', 'input_plant_activity', $data);
    }

    public function getKodeBudget()
    {
        $where = [
            'tahun'                  => $this->input->get("tahun"),
            'departement_id'         => $this->session->userdata("departement_id"),
            'master_jenis_budget_id' => $this->input->get("jenis")
        ];

        $data =  $this->model->ambilData("master_budget", $where);
        echo json_encode($data->result());
    }

    public function getSisaBudget()
    {
        $where = [
            'kode_budget'   => $this->input->get("kode_budget")
        ];
        $budget =  $this->model->ambilData("master_budget", $where);
        if ($budget->num_rows() > 0) {
            $bg  = $budget->row();
            $data_budget = $this->model->sisaBudgetDikurangiActual($bg->id_budget);
            echo json_encode($data_budget->row());
        } else {
            echo 0;
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data = [
            'data'      => $this->model->ambilData("master_planning_budget", ['master_budget_id_budget' => $id]),
            'detail'    => $this->model->DetaildaftarPlantBudgetDepartement($id)->row(),
        ];
        $this->load->view("detail_plant", $data);
    }
    public function viewDetailApprove()
    {
        $id = $this->input->post("id");
        $data = [
            'data'  => $this->model->ambilData("master_budget", ['id_budget' => $id])->row()
        ];
        $this->load->view("timeline_approved", $data);
    }


    public function input()
    {
        $listbulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $bulan    = $this->input->post("bulan");
        $activity = $this->input->post("activity");
        $id_budget = $this->input->post("id_budget");
        $query2 = $this->db->query('SELECT MAX(kode_plant_activity) as kode_plant_activity  FROM  master_planning_budget'); // mengambil nilai kode_barang terbesar

        $data = $query2->row();

        $kode = $data->kode_plant_activity; // kode_barang dengan angka terbesar

        $nourut = substr($kode, 4, 5); // contoh JRD0004, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut++;

        $params = array();
        for ($i = 0; $i < count($bulan); $i++) {
            $data = [
                'bulan'                     => $listbulan[$i],
                'nilai_budget'              => $bulan[$i] == null ? '0' : $bulan[$i],
                'master_budget_id_budget'   => $id_budget,
                'activity'                  => $activity,
                'status'                    => 0,
                'kode_plant_activity'       =>  'MPB' . sprintf("%05s", $nourut),
                'created_at'                => date('Y-m-d H:i:s'),
                'created_by'                => $this->session->userdata('nik')
            ];
            array_push($params, $data);
        }
        $save = $this->model->multiInsert($params, "master_planning_budget");
        if ($save > 0) {
            $this->session->set_flashdata("ok", "Planing budget di simpan");
            redirect('departement/Plant_budget/form_input_plant');
        } else {
            $this->session->set_flashdata("nok", "Planing budget gagal simpan");
            redirect('departement/Plant_budget/form_input_plant');
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
            redirect('departement/Plant_budget/list_budget');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/Plant_budget/list_budget');
        }
    }

    public function sync()
    {
        $id = $this->input->get("id_budget");
        $count = $this->db->query("SELECT sum(mpb.nilai_budget)  as nilai from master_planning_budget mpb where mpb.master_budget_id_budget = $id ")->row();
        $update = $this->model->updateData(['budget' => $count->nilai], "master_budget", ['id_budget' => $id]);
        if ($update > 0) {
            $this->db->trans_commit();
            // $this->db->where("master_budget_id_budget", $id);
            // $this->db->where("nilai_budget IS NULL", null, true);
            // $this->db->update("master_planning_budget", ['nilai_budget' => 0]);
            $this->session->set_flashdata("ok", 'plant budget di hapus');
            redirect('departement/Plant_budget/list_budget');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/Plant_budget/list_budget');
        }
    }


    public function form_edit()
    {
        $id = $this->input->get("id");
        $data = [
            'id'        => $id,
            'uri'       => $this->uri->segment(2),
            'jenis'     => $this->model->getData("master_jenis_budget")->result(),
            'plant'     => $this->db->query("SELECT mpb.nilai_budget , mpb.activity , mb.master_jenis_budget_id as jenis  from master_planning_budget mpb 
            left join master_budget mb on mb.id_budget  = mpb.master_budget_id_budget 
            where mpb.master_budget_id_budget   = $id")->result_array()

        ];
        $this->template->load("template_departement", "form_edit_budget_plant", $data);
    }

    public function updatePlant(Type $var = null)
    {
        $listbulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $id_budget = $this->input->post("id_budget");
        $bulan    = $this->input->post("bulan");
        $jenis    = $this->input->post("jenis_budget");
        $activity = $this->input->post("activity");
        $params = array();
        for ($i = 0; $i < count($bulan); $i++) {
            $data = [
                'bulan'                     => $listbulan[$i],
                'nilai_budget'              => $bulan[$i] == null ? '0' : $bulan[$i],
                'master_budget_id_budget'   => $id_budget,
                'activity'                  => $activity,
                'status'                    => 0,
                'created_at'                => date('Y-m-d H:i:s'),
                'created_by'                => $this->session->userdata('nik')
            ];
            array_push($params, $data);
        }


        $del = $this->model->delete(['master_budget_id_budget' => $id_budget], "master_planning_budget");
        if ($del > 0) {
            $this->db->trans_commit();
            $this->model->updateData(['master_jenis_budget_id' => $jenis, 'budget' => array_sum($bulan)], "master_budget", ['id_budget' => $id_budget]);
            $this->model->multiInsert($params, "master_planning_budget");
            $this->session->set_flashdata("ok", 'plant budget di perbarui');
            redirect('departement/Plant_budget/list_budget');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/Plant_budget/list_budget');
        }
    }
}
