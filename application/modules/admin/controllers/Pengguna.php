<?php

class Pengguna extends CI_Controller
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
            'uri'         => $this->uri->segment(2),
            'dataUser'    => $this->model->daftarUser(NULL)
        ];
        $this->template->load('template_admin', 'master_pengguna', $data);
    }

    public function form_add_user(Type $var = null)
    {
        $data = [
            'uri'         => $this->uri->segment(2),
            'level'       => $this->model->getData("master_level"),
            'departement' => $this->model->getData("master_departement"),
            'jenis_bayar'       => $this->model->getData("master_bayar")->result()
        ];
        $this->template->load('template_admin', 'form_add_pengguna', $data);
    }

    public function add()
    {
        $nama_lengkap = $this->input->post("nama_lengkap");
        $nik          = $this->input->post("nik");
        $username     = $this->input->post("username");
        $password     = $this->input->post("password");
        $level        = $this->input->post("level");
        $dept         = $this->input->post("departement[]");
        $jenis        = $this->input->post("jenis_pembayaran");
        $deptHead     = $this->db->query("SELECT `level` as dept FROM master_level where id  ='" . $level . "' ")->row();
        $dataDept = array();


        $data = [
            'nik'               => $nik,
            'nama_lengkap'      => $nama_lengkap,
            'user_name'         => $username,
            'level'             => $level,
            'departement_id'    => $dept[0],
            'status'            => 1,
            'password'          => md5($password),
            'created_at'        => date('Y-m-d H:i:s'),
            'master_bayar_id'   => $jenis
        ];
        $save = $this->model->insert("master_akun", $data);
        if ($save > 0) {
            if ($deptHead->dept == 'DEPT HEAD' || $deptHead->dept == 'dept head' || $deptHead->dept == 'DEPT HEAD 2' || $deptHead->dept == 'dept head 2') {
                for ($i = 0; $i < count($dept); $i++) {
                    $dataDep = array(
                        'master_akun_nik'       => $nik,
                        'master_departement_id' => $dept[$i]
                    );
                    array_push($dataDept, $dataDep);
                }
                $this->db->insert_batch("master_bawahan_depthead", $dataDept);
            }
            $this->session->set_flashdata("ok", "data berhasil di tambah");
            redirect('admin/Pengguna/form_add_user');
        } else {
            $this->session->set_flashdata("nok", "data gagal di tambah");
            redirect('admin/Pengguna/form_add_user');
        }
    }

    public function delete()
    {
        $id         = $this->input->get("id");
        $this->model->delete(['master_akun_nik' => $id], "master_bawahan_depthead");
        $delete     = $this->model->delete(['nik' => $id], "master_akun");
        if ($delete > 0) {
            $this->session->set_flashdata("ok", "data berhasil di hapus");
            redirect('admin/Pengguna');
        } else {
            $this->session->set_flashdata("nok", "data gagal di hapus");
            redirect('admin/Pengguna');
        }
    }

    public function resetPassword(Type $var = null)
    {
        $nik = $this->input->post("id");
        $data = [
            'password' => md5($this->input->post("password"))
        ];
        $update = $this->model->updateData($data, "master_akun", ['nik' => $nik]);
        if ($update > 0) {
            $this->session->set_flashdata("ok", "password berhasil di reset");
            redirect('admin/Pengguna');
        } else {
            $this->session->set_flashdata("nok", "data reset password");
            redirect('admin/Pengguna');
        }
    }

    public function form_edit_user($nik)
    {

        $data = [
            'uri'         => $this->uri->segment(2),
            'level'       => $this->model->getData("master_level"),
            'departement' => $this->model->getData("master_departement"),
            'user'        => $this->model->daftarUser($nik)->row(),
            'jenis_bayar'       => $this->model->getData("master_bayar")->result()
        ];
        $this->template->load('template_admin', 'form_edit_pengguna', $data);
    }

    public function update()
    {
        $nama_lengkap = $this->input->post("nama_lengkap");
        $nik          = $this->input->post("nik");
        $username     = $this->input->post("username");
        $level        = $this->input->post("level");
        $dept         = $this->input->post("departement[]");
        $jab          = $this->input->post("jab");
        $jenis        = $this->input->post("jenis_pembayaran");
        $dataDept = array();


        $data = [
            'nama_lengkap'      => $nama_lengkap,
            'user_name'         => $username,
            'level'             => $level,
            'departement_id'    => $dept[0],
            'status'            => 1,
            'master_bayar_id'   => $jenis,
            'created_at'        => date('Y-m-d H:i:s')
        ];
        $save = $this->model->updateData($data, "master_akun", ['nik' => $nik]);
        if ($save > 0) {
            if ($jab == 'DEPT HEAD' || $jab == 'dept head' || $jab == 'DEPT HEAD 2' || $jab == 'dept head 2') {
                $this->model->delete(['master_akun_nik' => $nik], "master_bawahan_depthead");
                for ($i = 0; $i < count($dept); $i++) {
                    $dataDep = array(
                        'master_akun_nik'       => $nik,
                        'master_departement_id' => $dept[$i]
                    );
                    array_push($dataDept, $dataDep);
                }
                $this->db->insert_batch("master_bawahan_depthead", $dataDept);
            }
            $this->session->set_flashdata("ok", "data berhasil di update");
            redirect('admin/Pengguna/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di update");
            redirect('admin/Pengguna/');
        }
    }
}
