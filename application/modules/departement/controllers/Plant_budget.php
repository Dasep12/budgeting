<?php

class Plant_budget extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
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

    public function getBudget()
    {
        $where = [
            'tahun'                  => $this->input->get("tahun"),
            'status'                 => 4,
            'departement_id'         => $this->session->userdata("departement_id"),
            'master_jenis_budget_id' => $this->input->get("jenis")
        ];

        $data = $this->model->ambilData("master_budget", $where);
        if ($data->num_rows() > 0) {
            echo json_encode($data->row());
        } else {
            echo "0";
        }
    }

    public function input()
    {
        $listbulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $bulan    = $this->input->post("bulan");
        $activity = $this->input->post("activity");
        $id_budget = $this->input->post("id_budget");

        $params = array();
        for ($i = 0; $i < count($bulan); $i++) {
            $data = [
                'bulan'                     => $listbulan[$i],
                'nilai_budget'              => $bulan[$i],
                'master_budget_id_budget'   => $id_budget,
                'activity'                  => $activity,
                'status'                    => 0,
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
}
