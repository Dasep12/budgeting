<?php

class SubJenisBudget extends CI_Controller
{
    public function __construct(Type $var = null)
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
            'data'      => $this->model->getData("master_sub_jenis_budget")
        ];
        $this->template->load('template_admin', 'master_subjenis_budget', $data);
    }

    public function input()
    {
        $jenis  = $this->input->post("jenis_budget2");
        $data = [
            'sub_jenis_budget'  => $jenis
        ];
        $save = $this->model->insert("master_sub_jenis_budget", $data);
        if ($save > 0) {
            $this->session->set_flashdata("ok", "data berhasil di tambah");
            redirect('admin/SubJenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di tambah");
            redirect('admin/SubJenisBudget/');
        }
    }

    public function delete()
    {
        $id  = $this->input->get("id");
        $where = [
            'id'  => $id
        ];
        $delete = $this->model->delete($where, ['master_sub_jenis_budget']);
        if ($delete > 0) {
            $this->session->set_flashdata("ok", "data berhasil di hapus");
            redirect('admin/SubJenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di hapus");
            redirect('admin/SubJenisBudget/');
        }
    }

    public function update(Type $var = null)
    {
        $jenis  = $this->input->post("sub_jenis_budget");
        $id  = $this->input->post("id");
        $data = [
            'sub_jenis_budget'  => $jenis
        ];
        $upd = $this->model->updateData($data, "master_sub_jenis_budget", ['id' => $id]);
        if ($upd > 0) {
            $this->session->set_flashdata("ok", "data berhasil di update");
            redirect('admin/SubJenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di update");
            redirect('admin/SubJenisBudget/');
        }
    }
}
