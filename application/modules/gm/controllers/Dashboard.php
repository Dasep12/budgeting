<?php

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_gm', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'gm') {
            redirect('Login');
        }
    }
    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_gm', 'dashboard', $data);
    }
}
