<?php

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
    }
    public function index()
    {

        $data = [
            'uri'           => $this->uri->segment(2),
            'plan_budget'   => $this->model->totalPlaningBudget($this->session->userdata("departement_id")),
            'actual_budget' => $this->model->totalActualBudget($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'dashboard', $data);
    }
}
