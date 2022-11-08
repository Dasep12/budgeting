<?php

class Master_budget extends CI_Controller
{

    public function index()
    {
        $this->template->load('template/template_admin', 'master_budget');
    }
}
