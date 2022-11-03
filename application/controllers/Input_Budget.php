<?php


class Input_Budget extends CI_Controller
{

    public function index()
    {
        $this->template->load('template/template_admin', 'input_budget');
    }
}
