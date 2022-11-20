<?php

class Budget extends CI_Controller
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
            'budget'      => $this->model->daftarBudget($this->session->userdata("departement_id"))->result()
        ];
        $this->template->load('template_departement', 'budget', $data);
    }
}
