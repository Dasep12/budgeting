<?php

class Laporan extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'FIN') {
            redirect('Login');
        }
    }

    public function payment()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->getData("master_departement"),
            'jenis'         => $this->db->query("SELECT id , jenis_transaksi from master_jenis_transaksi WHERE jenis_transaksi = 'PAYMENT VOUCHER' ")
        ];
        $this->template->load('template_fin', 'form_laporan_payment', $data);
    }

    public function panjer()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->getData("master_departement"),
            'jenis'         => $this->db->query("SELECT id , jenis_transaksi from master_jenis_transaksi WHERE jenis_transaksi = 'PANJAR' ")
        ];
        $this->template->load('template_fin', 'form_laporan_panjer', $data);
    }

    public function apvoucher()
    {
        $nik = $this->session->userdata("nik");
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->getData("master_departement"),
            'jenis'         => $this->db->query("SELECT id , jenis_transaksi from master_jenis_transaksi WHERE jenis_transaksi = 'AP VOUCHER' ")
        ];
        $this->template->load('template_fin', 'form_laporan_voucher', $data);
    }

    public function list_voucher()
    {
        $dept = $this->input->get("deptId");
        $start = $this->input->get("start");
        $end = $this->input->get("end");
        $jenis = $this->input->get("jenis");
        $data = [];
        $data = $this->model->reportVoucher($dept, $jenis, $start, $end)->result();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }

    public function list_payment()
    {
        $dept = $this->input->get("deptId");
        $start = $this->input->get("start");
        $end = $this->input->get("end");
        $jenis = $this->input->get("jenis");
        $data = [];
        $data = $this->model->reportPayment($dept, $jenis, $start, $end)->result();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }
}
