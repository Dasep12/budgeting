<?php


class Approve_trans extends CI_Controller
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

    public function list_approve_trans()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->listTransaksi($this->session->userdata("bayar_id"), 0)
        ];
        $this->template->load('template_fin', 'list_approved_trans', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id");
        $kode = $this->input->get("kode");
        $data = [
            'status_approved'            => $kode,
            'ket'                        => $kode == 1 ? 'accept finance' : 'reject finance',
            'date_approve_fin'           => date('Y-m-d H:i:s'),
            'approve_fin'                => $kode,
            'approve_fin_user'           => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_jenis_pembayaran", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'transaksi telah di setujui' : 'transaksi telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('finance/Approve_trans/list_approve_trans');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_trans/list_approve_trans');
        }
    }

    public function viewDetailRaimbes()
    {
        $id    = $this->input->post("id");
        $file1 = $this->input->post("file1");
        $file2 = $this->input->post("file2");
        $file3 = $this->input->post("file3");
        $nama  = $this->input->post("nama");
        $remarks  = $this->input->post("remarks");
        $jenis  = $this->input->post("jenis");
        $data = [
            'raimbus'   => $this->model->ambilData('trans_detail_jenis_pembayaran', ['transaksi_jenis_pembayaran_id' => $id]),
            'file1'      => $file1,
            'file2'      => $file2,
            'file3'      => $file3,
            'nama'       => $nama,
            'remarks'    => $remarks,
            'jenis'       => $jenis,
        ];
        $this->load->view("detail_approved_trans", $data);
    }

    public function histori_approve_trans()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->listTransaksi($this->session->userdata("departement_id"), 1, $sess)
        ];
        $this->template->load('template_fin', 'histori_raimbusment_approved', $data);
    }

    public function multiApprove()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status_approved'    => 1,
                'ket'                => 'accept finance',
                'date_approve_fin'   => date('Y-m-d H:i:s'),
                'approve_fin'        => 1,
                'approve_fin_user'   => $this->session->userdata("nik"),
                'id'                 => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('transaksi_jenis_pembayaran', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('finance/Approve_trans/list_approve_trans');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_trans/list_approve_trans');
        }
    }

    public function closePayment()
    {
        $id = $this->input->get("id");
        $kode = $this->input->get("kode");
        $data = [
            'payment_close'              => $kode,
            'date_payment_close'         => date('Y-m-d H:i:s'),
        ];
        $update = $this->model->updateData($data, "transaksi_jenis_pembayaran", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "transaksi telah di tutup,silahkan konfirmasi ke departement terkait");
            redirect('finance/Approve_trans/histori_approve_trans');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_trans/histori_approve_trans');
        }
    }
}
