<?php

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_gm', 'model1');
        $this->load->model('M_dashboard', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'GM') {
            redirect('Login');
        }
    }
    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'depar'     => $this->model1->getDept(),
            'plantBudget'       => $this->model->getTotalPlaning(date('Y')),
            'actualBudget'      => $this->model->getTotalActual(date('Y')),
            'dept'            => $this->model->queryDepartement()
        ];
        $this->template->load('template_gm', 'dashboard', $data);
    }

    public function getPlant()
    {
        $tahun = $this->input->get("tahun");
        if ($tahun == NULL) {
            $thn = date('Y');
        } else {
            $thn = $tahun;
        }
        $nik = $this->session->userdata("nik");
        $plant = $this->model->getTotalPlaning($thn);
        $actual = $this->model->getTotalActual($thn);
        $result = array(
            'plant'     => $plant,
            'actual'    => $actual
        );
        echo json_encode($result);
    }

    public function getActual()
    {
        $tahun = $this->input->get("tahun");
        if ($tahun == NULL) {
            $thn = date('Y');
        } else {
            $thn = $tahun;
        }
        $nik = $this->session->userdata("nik");
        $query = $this->model->getTotalActual($thn);
        echo $query;
    }

    public function getDepartement()
    {
        $year = $this->input->post("tahun");
        $dept = $this->input->post("dept");
        $kode = $this->model->getDetailPerDepartement($year, $dept)->result_array();

        $kodeBudget = array();
        foreach ($kode as $key => $rso) {
            $kodeBudget[] = $rso['kode_budget'];
        }

        $plantBudget = array();
        foreach ($kode as $key => $rso) {
            $plantBudget[] = $rso['plant_budget'];
        }
        $actualBudget = array();
        foreach ($kode as $key => $rso) {
            $actualBudget[] = $rso['actual_budget'];
        }

        $sisaBudget = array();
        foreach ($kode as $key => $rso) {
            $sisaBudget[] = $rso['sisa_budget'];
        }

        $data = array(
            'plant' => $plantBudget,
            'actual' => $actualBudget,
            'sisa'   => $sisaBudget,
            'kode'   => $kodeBudget
        );
        echo json_encode($data, true);
    }
}
