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
}
