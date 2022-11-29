<?php

class Dashboard extends CI_Controller
{

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_admin', 'dashboard', $data);
    }
}
