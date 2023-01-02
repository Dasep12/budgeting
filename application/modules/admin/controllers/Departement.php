<?php

class Departement extends CI_Controller
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
            'data'      => $this->model->getData("master_departement")
        ];
        $this->template->load('template_admin', 'master_departement', $data);
    }

    public function input()
    {
        $nama  = $this->input->post("nama_departement");
        $kode  = $this->input->post("kode_departement");
        $data = [
            'nama_departement'      => $nama,
            'kode_departement'      => $kode
        ];

        $search = $this->db->query("SELECT * FROM master_departement WHERE nama_departement='" . $nama . "' or kode_departement ='" . $kode . "' ");
        if ($search->num_rows() > 0) {
            $this->session->set_flashdata("nok", "data sudah ada di master");
            redirect('admin/Departement/');
        } else {
            $save = $this->model->insert("master_departement", $data);
            if ($save > 0) {
                $this->session->set_flashdata("ok", "data berhasil di tambah");
                redirect('admin/Departement/');
            } else {
                $this->session->set_flashdata("nok", "data gagal di tambah");
                redirect('admin/Departement/');
            }
        }
    }

    public function edit()
    {
        $nama  = $this->input->post("nama_departement_3");
        $kode  = $this->input->post("kode_departement_3");
        $id    = $this->input->post("id");
        $data = [
            'nama_departement'      => $nama,
            'kode_departement'      => $kode
        ];

        $update = $this->model->updateData($data, "master_departement", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "data berhasil di ubah");
            redirect('admin/Departement/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di ubah");
            redirect('admin/Departement/');
        }
    }
}
