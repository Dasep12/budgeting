<?php

class Tertanda extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_admin', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'data'      => $this->model->getData("master_departement"),
            'akun'      => $this->model->getData("master_akun")
        ];
        $this->template->load('template_admin', 'master_tertanda', $data);
    }

    public function input()
    {
        $user  = $this->input->post("user");
        $config = array(
            'upload_path'   => './assets/ttd/',
            'allowed_types' => 'jpg|png|jpeg',
            'overwrite'     => true,
        );

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("lampiran")) {
            $search = $this->db->query("SELECT * FROM master_tertanda WHERE master_akun_nik = '" . $user . "' ");
            $data = [
                'master_akun_nik'       => $user,
                'file'                  => $this->upload->data('file_name'),
                'created_at'            => date('Y-m-d H:i:s')
            ];
            if ($search->num_rows() > 0) {
                $this->session->set_flashdata("nok", "data sudah ada di master");
                redirect('admin/Tertanda/');
            } else {
                $save = $this->model->insert("master_tertanda", $data);
                if ($save > 0) {
                    $this->session->set_flashdata("ok", "data berhasil di tambah");
                    redirect('admin/Tertanda/');
                } else {
                    $this->session->set_flashdata("nok", "data gagal di tambah");
                    redirect('admin/Tertanda/');
                }
            }
        } else {
            $this->session->set_flashdata("nok", $this->upload->display_errors());
            redirect('admin/Tertanda/');
        }
    }
}
