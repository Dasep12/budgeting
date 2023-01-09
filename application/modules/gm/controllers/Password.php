<?php

use function PHPSTORM_META\map;

class Password extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_gm', 'model');
        $this->load->helper('convertbulan');
        date_default_timezone_set('Asia/Jakarta');

        $role = $this->session->userdata("level");
        if ($role != 'GM') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
        ];
        $this->template->load('template_gm', 'form_password', $data);
    }

    public function reset(Type $var = null)
    {
        $old = $this->input->post("old_password");
        $pass = md5($this->input->post("new_password"));
        $nik = $this->session->userdata("nik");
        $search = $this->model->ambilData("master_akun", ['nik' => $nik, 'password' => md5($old)]);
        if ($search->num_rows() > 0) {
            $data = [
                'password'  =>  $pass
            ];
            $update = $this->model->updateData($data, "master_akun", ['nik' => $nik]);
            if ($update > 0) {
                $this->session->set_flashdata("ok", "Perubahan password di simpan");
                redirect('gm/Password');
            } else {
                $this->session->set_flashdata("nok", "Planing budget gagal simpan");
                redirect('gm/Password');
            }
        } else {
            $this->session->set_flashdata("nok", "Password lama tidak sesuai");
            redirect('gm/Password');
        }
    }
}
