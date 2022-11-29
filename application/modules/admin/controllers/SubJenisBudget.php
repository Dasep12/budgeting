<?php

class SubJenisBudget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_admin', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'data'      => $this->model->getData("master_sub_jenis_budget")
        ];
        $this->template->load('template_admin', 'master_subjenis_budget', $data);
    }

    public function input(Type $var = null)
    {
        $nama  = $this->input->post("nama_departement");
        $kode  = $this->input->post("kode_departement");
    }
}
