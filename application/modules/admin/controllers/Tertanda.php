<?php

class Tertanda extends CI_Controller
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
            'data'      => $this->model->getData("master_departement"),
            'akun'      => $this->db->query("SELECT ma.nik , ml.level , ma.nama_lengkap , md.nama_departement as dept FROM  master_akun ma INNER JOIN master_departement md on md.id = ma.departement_id INNER JOIN master_level ml on ml.id = ma.level "),
            'ttd'       => $this->model->getTertanda()
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
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->session->userdata("nik")
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

    public function update()
    {
        $config = array(
            'upload_path'   => './assets/ttd/',
            'allowed_types' => 'jpg|png|jpeg',
            'overwrite'     => true,
        );
        $id = $this->input->post("id_2");

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("lampiran_1")) {

            $data = [
                'file'                  => $this->upload->data('file_name'),
                'updated_at'            => date('Y-m-d H:i:s'),
                'updated_by'            => $this->session->userdata("nik")
            ];
            $update = $this->model->updateData($data, "master_tertanda", ['id' => $id]);
            if ($update > 0) {
                $this->session->set_flashdata("ok", "data berhasil di update");
                redirect('admin/Tertanda/');
            } else {
                $this->session->set_flashdata("nok", "data gagal di update");
                redirect('admin/Tertanda/');
            }
        } else {
            $this->session->set_flashdata("nok", $this->upload->display_errors());
            redirect('admin/Tertanda/');
        }
    }

    public function delete()
    {
        $id  = $this->input->get("id");
        $where = [
            'id'  => $id
        ];
        $delete = $this->model->delete($where, ['master_tertanda']);
        if ($delete > 0) {
            $this->session->set_flashdata("ok", "data berhasil di hapus");
            redirect('admin/Tertanda/');
        } else {
            $this->session->set_flashdata("nok", "data gagal di hapus");
            redirect('admin/Tertanda/');
        }
    }
}
