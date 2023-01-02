<?php

class JenisBudget extends CI_Controller
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
            'data'      => $this->model->getData("master_jenis_budget")
        ];
        $this->template->load('template_admin', 'master_jenis_budget', $data);
    }

    public function input(Type $var = null)
    {
        $jenis  = $this->input->post("jenis_budget2");
        $data = [
            'jenis_budget'  => $jenis
        ];
        $save = $this->model->insert("master_jenis_budget", $data);
        if ($save > 0) {
            $this->session->set_flashdata("ok", "data berhasil di tambah");
            redirect('admin/JenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di tambah");
            redirect('admin/JenisBudget/');
        }
    }

    public function delete(Type $var = null)
    {
        $id  = $this->input->get("id");
        $where = [
            'id'  => $id
        ];
        $delete = $this->model->delete($where, ['master_jenis_budget']);
        if ($delete > 0) {
            $this->session->set_flashdata("ok", "data berhasil di hapus");
            redirect('admin/JenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di hapus");
            redirect('admin/JenisBudget/');
        }
    }

    public function update(Type $var = null)
    {
        $jenis  = $this->input->post("jenis_budget");
        $id  = $this->input->post("id");
        $data = [
            'jenis_budget'  => $jenis
        ];
        $upd = $this->model->updateData($data, "master_jenis_budget", ['id' => $id]);
        if ($upd > 0) {
            $this->session->set_flashdata("ok", "data berhasil di update");
            redirect('admin/JenisBudget/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di update");
            redirect('admin/JenisBudget/');
        }
    }
}
