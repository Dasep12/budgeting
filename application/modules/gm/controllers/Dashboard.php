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
        $query = $this->model->getTotalPlaning($thn);
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
        $query = $this->model->getTotalActual($thn);
        echo $query;
    }
}
