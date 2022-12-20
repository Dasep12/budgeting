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
            switch ($level) {
                case 'mgr':
                    redirect('manager/Dashboard');
                    break;
                case 'dpt':
                    redirect('departement/Dashboard');
                    break;
                case 'fin':
                    redirect('finance/Dashboard');
                    break;
                case 'bc':
                    redirect('budgetControl/Dashboard');
                    break;
                case 'gm':
                    redirect('gm/Dashboard');
                    break;
                case 'adm':
                    redirect('admin/Dashboard');
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
