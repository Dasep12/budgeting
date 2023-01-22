<?php

class Login extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model("M_login", 'login');
    }
    public function index()
    {
        $this->load->view("login");
        // echo md5('123');
    }

    public function cek_login()
    {
        $user = $this->input->post("user");
        $password = $this->input->post("password");
        $cek = $this->login->cek_login($user, md5($password));
        if ($cek->num_rows() > 0) {
            $data = $cek->row();
            $level  = $data->level;
            $this->session->set_userdata("nik", $data->nik);
            $this->session->set_userdata("departement_id", $data->departement_id);
            $this->session->set_userdata("level", $level);
            $this->session->set_userdata("nama", $data->nama_lengkap);
            $this->session->set_userdata("bayar_id", $data->bayar_id);
            switch ($level) {
                case 'MGR':
                    redirect('manager/Dashboard');
                    break;
                case 'DPT':
                    redirect('departement/Dashboard');
                    break;
                case 'FIN':
                    redirect('finance/Dashboard');
                    break;
                case 'BC':
                    redirect('budgetControl/Dashboard');
                    break;
                case 'GM':
                    redirect('gm/Dashboard');
                    break;
                case 'ADM':
                    redirect('admin/Dashboard');
                    break;
                case 'SPV':
                    redirect('spv/Dashboard');
                    break;

                default:
                    echo 'tidak  ada level';
                    break;
            }
        } else {

            $this->session->set_flashdata("fail", "akun tidak ada");
            redirect('Login');
        }
    }
}
