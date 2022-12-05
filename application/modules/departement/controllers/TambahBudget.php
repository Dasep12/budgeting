<?php

class TambahBudget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
    }
    public function index()
    {

        $data = [
            'uri'       => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget")->result(),
        ];
        $this->template->load('template_departement', 'tambah_budget', $data);
    }

    public function input()
    {
        # code...
    }
}
