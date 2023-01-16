<?php

class Dashboard extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_dashboard', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'SPV') {
            redirect('Login');
        }
    }
    public function index()
    {
        $nik = $this->session->userdata("nik");
        $dept = $this->session->userdata("departement_id");
        $data = [
            'uri'             => $this->uri->segment(2),
            'depar'           => $this->model->ambilData($nik),
            'plantTotal'      => $this->model->getTotalPlaning(date('Y'), $dept),
            'plantActual'     => $this->model->getTotalActual(date('Y'), $dept),
        ];
        $this->template->load('template_supervisor', 'dashboard', $data);
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
