<?php

class Master_perusahaan extends CI_Controller
{

    public function index()
    {
        $this->template->load('template/template_admin', 'master_perusahaan');
    }
}
