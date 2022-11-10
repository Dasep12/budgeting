<?php

class Plant_budget extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
    }

    public function list_budget()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
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
            'status'                 => 1,
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
        # code...
    }
}
