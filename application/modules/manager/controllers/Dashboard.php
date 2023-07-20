<?php

class Dashboard extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_dashboard', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'MGR') {
            redirect('Login');
        }
    }
    public function index()
    {
        $nik = $this->session->userdata("nik");
        $data = [
            'uri'             => $this->uri->segment(2),
            'depar'           => $this->model->getDept($nik),
            'plantTotal'      => $this->model->getTotalPlaning($nik, date('Y')),
            'plantActual'     => $this->model->getTotalActual($nik, date('Y')),
            'dept'            => $this->model->queryDepartement($nik)
        ];
        $this->template->load('template_manager', 'dashboard', $data);
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
        $query = $this->model->getTotalPlaning($nik, $thn);
        echo $query;
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
        $query = $this->model->getTotalActual($nik, $thn);
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
