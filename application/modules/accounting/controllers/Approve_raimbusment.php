<?php


class Approve_raimbusment extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_accounting', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_approve_raim()
    {
        $data = [
            'uri'        => $this->uri->segment(2),
            'raimbus'    => $this->model->ambilData("transaksi_jenis_pembayaran", ['approve_acc' => 0])
        ];
        $this->template->load('template_acc', 'list_raimbusment_approved', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id");
        $kode = $this->input->get("kode");
        $data = [
            'status_approved'            => $kode,
            'ket'               => $kode == 1 ? 'accept accounting' : 'reject accounting',
            'date_approve_acc' => date('Y-m-d H:i:s'),
            'approve_acc'       => $kode,
            'approve_acc_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_jenis_pembayaran", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "raimbes telah di setujui, silahkan konfirmasi ke pihak Finnance");
            redirect('accounting/Approve_raimbusment/list_approve_raim');
        } else {
            $this->session->set_flashdata("nok", "raimbes di tolak");
            redirect('accounting/Approve_raimbusment/list_approve_raim');
        }
    }

    public function viewDetailRaimbes()
    {
        $id = $this->input->post("id");
        $data = [
            'raimbus'   => $this->model->ambilData('trans_detail_jenis_pembayaran', ['transaksi_jenis_pembayaran_id' => $id])
        ];
        $this->load->view("detail_raimbusment", $data);
    }

    public function histori_approve_raim()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->ambilData("transaksi_jenis_pembayaran", ['approve_acc  !=' => 0])
        ];
        $this->template->load('template_acc', 'histori_raimbusment_approved', $data);
    }
}
