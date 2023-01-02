<?php

class AccountName extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'ADM') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'data'      => $this->model->getData("master_acc")
        ];
        $this->template->load('template_admin', 'master_acc_name', $data);
    }

    public function input()
    {
        $ket  = $this->input->post("keterangan");
        $accNo  = $this->input->post("acc_no");
        $accName  = $this->input->post("acc_name");
        $data = [
            'acc_no'    => $accNo,
            'acc_name'  => $accName,
            'ket'       => $ket,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata("nik")
        ];
        $save = $this->model->insert("master_acc", $data);
        if ($save > 0) {
            $this->session->set_flashdata("ok", "data berhasil di tambah");
            redirect('admin/AccountName/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di tambah");
            redirect('admin/AccountName/');
        }
    }

    public function delete()
    {
        $id  = $this->input->get("id");
        $where = [
            'id'  => $id
        ];
        $delete = $this->model->delete($where, ['master_acc']);
        if ($delete > 0) {
            $this->session->set_flashdata("ok", "data berhasil di hapus");
            redirect('admin/AccountName/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di hapus");
            redirect('admin/AccountName/');
        }
    }

    public function update()
    {
        $id  = $this->input->post("id");
        $ket  = $this->input->post("keterangan_2");
        $accNo  = $this->input->post("acc_no_2");
        $accName  = $this->input->post("acc_name_2");
        $data = [
            'acc_no'     => $accNo,
            'acc_name'   => $accName,
            'ket'        => $ket,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $upd = $this->model->updateData($data, "master_acc", ['id' => $id]);
        if ($upd > 0) {
            $this->session->set_flashdata("ok", "data berhasil di update");
            redirect('admin/AccountName/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di update");
            redirect('admin/AccountName/');
        }
    }
}
