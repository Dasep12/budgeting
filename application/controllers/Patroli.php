<?php


class Patroli extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_user', 'user');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function lokasi(Type $var = null)
    {
        $data = [
            'lokasi'   => $this->user->getPatroli(1)
        ];
        $this->load->view("header");
        $this->load->view("list_lokasi", $data);
        $this->load->view("footer");
    }


    public function scan_barcode(Type $var = null)
    {
        $id_lokasi = $this->input->get("id_lokasi");
        $id_setting = $this->input->get("id_setting");
        $data = [
            'id'           =>  $id_lokasi,
            'id_set'       =>  $id_setting,
        ];
        $this->load->view("header");
        $this->load->view("scan_barcode", $data);
        $this->load->view("footer");
    }

    public function input_report()
    {
        $data = [
            ''
        ];
        $this->load->view("header");
        $this->load->view("input_report", $data);
        $this->load->view("footer");
    }
}
