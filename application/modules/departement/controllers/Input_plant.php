<?php

class Input_plant extends CI_Controller
{
    public function form(Type $var = null)
    {
        $this->template->load('template_departement', 'input_plant_activity');
    }
}
