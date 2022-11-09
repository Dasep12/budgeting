<?php


class Approved extends CI_Controller

{
    public function list_approve()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_manager', 'list_approved', $data);
    }
}
