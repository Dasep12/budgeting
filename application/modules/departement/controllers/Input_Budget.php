<?php


class Input_Budget extends CI_Controller
{

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_departement', 'input_budget', $data);
    }
}
