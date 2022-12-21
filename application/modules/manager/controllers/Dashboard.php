<?php

class Dashboard extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_manager', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'MGR') {
            redirect('Login');
        }
    }
    public function index()
    {

        $data = [
            'uri'       => $this->uri->segment(2),
            'depar'     => $this->model->getDept()
        ];
        $this->template->load('template_manager', 'dashboard', $data);
    }
}
