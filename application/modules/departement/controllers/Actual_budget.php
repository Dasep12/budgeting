<?php

class Actual_budget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_actual()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'daftar'    => $this->model->daftarActualActivity($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'daftar_actual_budget_activity', $data);
    }

    public function form_input_actual()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'jenis'     => $this->model->getData("master_jenis_budget")->result()
        ];
        $this->template->load('template_departement', 'input_actual_activity', $data);
    }

    public function getBudget()
    {
        $dept = $this->session->userdata("departement_id");
        $tahun = $this->input->get("tahun");
        $bulan = $this->input->get("bulan");
        $jenis = $this->input->get("jenis");
        $data = $this->model->PlantBudgetDepartementPerBulan($dept, $tahun, $bulan, $jenis);
        if ($data->num_rows() > 0) {
            $budget_p = $data->row();
            $detail = $this->model->getActualPlantBudgetBulanan($budget_p->id_planing);
            if ($detail->budget_actual == "" || $detail->budget_actual == null) {
                echo json_encode($data->row());
            } else {
                echo json_encode($detail);
            }
        } else {
            echo 0;
        }
    }

    public function input(Type $var = null)
    {
        $kode_planning = $this->input->post("id_planning");
        $activity      = $this->input->post("activity");
        $budget        = $this->input->post("use_budget");
        $data =  [
            'master_planning_budget_id_planing'    => $kode_planning,
            'nilai_budget'                         => $budget,
            'activity'                             => $activity,
            'created_at'                           => date('Y-m-d H:i:s'),
            'created_by'                           => $this->session->userdata("nik"),
            'status'                               => 1,
            'tanggal_transaksi'                    => date('Y-m-d')
        ];

        $save = $this->model->insert("transaksi_actual_budget", $data);
        if ($save > 0) {
            $this->session->set_flashdata("ok", "berhasil di input");
            redirect('departement/Actual_budget/form_input_actual');
        } else {
            $this->session->set_flashdata("nok", "gagal di input");
            redirect('departement/Actual_budget/form_input_actual');
        }
    }
}
