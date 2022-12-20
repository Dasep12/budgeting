<?php


class Approve_trans extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_bc', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'bc') {
            redirect('Login');
        }
    }

    public function list_approve_trans()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->model->listTransaksi(0)
        ];
        $this->template->load('template_bc', 'list_approved_trans', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id");
        $kode = $this->input->get("kode");
        $data = [
            'status_approved'            => $kode,
            'ket'                        => $kode == 1 ? 'accept budget controller' : 'reject budget controller',
            'date_approve_acc'           => date('Y-m-d H:i:s'),
            'approve_acc'                => $kode,
            'approve_acc_user'           => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_jenis_pembayaran", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", $kode == 1 ? 'transaksi telah di setujui' : 'transaksi telah di tolak ' . ",silahkan konfirmasi ke departement terkait");
            redirect('budgetControl/Approve_trans/list_approve_trans');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('budgetControl/Approve_trans/list_approve_trans');
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
        $data = [
            'uri'       => $this->uri->segment(2),
            'raimbus'    => $this->db->query("SELECT tjp.id , tjp.ket , ma.nama_lengkap , tjp.request_code , tjp.remarks , tjp.lampiran_1 , tjp.lampiran_2  , tjp.lampiran_3  , tjp.created_by , 
            tjp.tanggal_request , mjt.jenis_transaksi  
            from transaksi_jenis_pembayaran tjp  
            left join master_akun ma  on ma.nik  = tjp.created_by  
            left join master_jenis_transaksi mjt on mjt.id  = tjp.master_jenis_transaksi_id 
            where tjp.approve_mgr  != 0 ")
        ];
        $this->template->load('template_bc', 'histori_raimbusment_approved', $data);
    }
}
