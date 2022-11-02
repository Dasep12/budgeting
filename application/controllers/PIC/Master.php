<?php


class Master extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_pic', 'admin');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function plant()
    {
        $data  = [
            'plant'     => $this->admin->show("master_plant")
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/master_plant", $data);
        $this->load->view("template/pic/footer");
    }

    public function input_plant(Type $var = null)
    {
        $plant      = $this->input->post("plant");
        $wilayah    = $this->input->post("wilayah");
        $data  = [
            'nama_plant'    => $plant,
            'wilayah'       => $wilayah,
            'status'        => 1,
            'created_at'    => date('Y-m-d H:i:s')
        ];
        $save       = $this->admin->insert($data, "master_plant");
        if ($save >= 1) {
            $this->session->set_flashdata("ok", "Berhasil input data");
            redirect('PIC/Master/plant');
        } else {
            $this->session->set_flashdata("ok", "Gagal input data");
            redirect('PIC/Master/plant');
        }
    }

    public function edit_plant(Type $var = null)
    {
        $plant      = $this->input->post("plant_2");
        $wilayah    = $this->input->post("wilayah_2");
        $id    = $this->input->post("id_plant");
        $data  = [
            'nama_plant'    => $plant,
            'wilayah'       => $wilayah,
            'status'        => 1,
            // 'created_at'    => date('Y-m-d H:i:s')
        ];
        $update      = $this->admin->update($data, "master_plant", ['id' => $id]);
        if ($update >= 1) {
            $this->session->set_flashdata("ok", "Berhasil edit data");
            redirect('PIC/Master/plant');
        } else {
            $this->session->set_flashdata("nok", "Gagal edit data");
            redirect('PIC/Master/plant');
        }
    }

    public function delete_plant()
    {
        $id    = $this->input->get("id_plant");
        $delete      = $this->admin->delete(['id' => $id], 'master_plant');
        if ($delete >= 1) {
            $this->session->set_flashdata("ok", "Berhasil hapus data");
            redirect('PIC/Master/plant');
        } else {
            $this->session->set_flashdata("ok", "Gagal hapus data");
            redirect('PIC/Master/plant');
        }
    }

    public function lokasi()
    {
        $data = [
            'plant'          =>  $this->admin->show("master_plant")->result(),
            'lokasi_data'    => $this->admin->lokasi()
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/master_lokasi", $data);
        $this->load->view("template/pic/footer");
    }

    public function input_lokasi(Type $var = null)
    {
        $plant      = $this->input->post("plant");
        $lokasi    = $this->input->post("lokasi");
        $latitude    = $this->input->post("latitude");
        $longitude    = $this->input->post("longitude");
        $data  = [
            'master_plant_id'    => $plant,
            'nama_lokasi'        => $lokasi,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
            'status'             => 1,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        $save       = $this->admin->insert($data, "master_lokasi");
        if ($save >= 1) {
            $this->session->set_flashdata("ok", "Berhasil input data");
            redirect('PIC/Master/lokasi');
        } else {
            $this->session->set_flashdata("ok", "Gagal input data");
            redirect('PIC/Master/lokasi');
        }
    }

    public function delete_lokasi()
    {
        $id    = $this->input->get("id_lokasi");
        $delete      = $this->admin->delete(['id' => $id], 'master_lokasi');
        if ($delete >= 1) {
            $this->session->set_flashdata("ok", "Berhasil hapus data");
            redirect('PIC/Master/lokasi');
        } else {
            $this->session->set_flashdata("nok", "Gagal hapus data");
            redirect('PIC/Master/lokasi');
        }
    }

    public function edit_lokasi(Type $var = null)
    {
        $plant      = $this->input->post("plant_2");
        $lokasi    = $this->input->post("lokasi_2");
        $latitude    = $this->input->post("latitude_2");
        $longitude    = $this->input->post("longitude_2");
        $id    = $this->input->post("id_lokasi");
        $data  = [
            // 'master_plant_id'    => $plant,
            'nama_lokasi'        => $lokasi,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
        ];
        $save       = $this->admin->update($data, "master_lokasi", ['id' => $id]);
        if ($save >= 1) {
            $this->session->set_flashdata("ok", "Berhasil update data");
            redirect('PIC/Master/lokasi');
        } else {
            $this->session->set_flashdata("nok", "Gagal update data");
            redirect('PIC/Master/lokasi');
        }
    }


    public function user()
    {
        $data = [
            'plant'  =>  $this->admin->show("master_plant")->result(),
            'user'  =>  $this->admin->user()->result(),
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/master_user", $data);
        $this->load->view("template/pic/footer");
    }

    public function input_user(Type $var = null)
    {
        $plant       = $this->input->post("plant");
        $nama        = $this->input->post("nama");
        $npk         = $this->input->post("npk");
        $level       = $this->input->post("level");
        $password    = $this->input->post("password");
        $data  = [
            'master_plant_id'    => $plant,
            'nama_user'          => $nama,
            'npk'                => $npk,
            'level'              => $level,
            'password'           => md5($password),
            'status'             => 1,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        $save       = $this->admin->insert($data, "master_user");
        if ($save >= 1) {
            $this->session->set_flashdata("ok", "Berhasil input data");
            redirect('PIC/Master/user');
        } else {
            $this->session->set_flashdata("ok", "Gagal input data");
            redirect('PIC/Master/user');
        }
    }

    public function delete_user()
    {
        $id    = $this->input->get("id_lokasi");
        $delete      = $this->admin->delete(['id' => $id], 'master_lokasi');
        if ($delete >= 1) {
            $this->session->set_flashdata("ok", "Berhasil hapus data");
            redirect('PIC/Master/user');
        } else {
            $this->session->set_flashdata("nok", "Gagal hapus data");
            redirect('PIC/Master/user');
        }
    }

    public function edit_user(Type $var = null)
    {
        $plant      = $this->input->post("plant_2");
        $lokasi    = $this->input->post("lokasi_2");
        $latitude    = $this->input->post("latitude_2");
        $longitude    = $this->input->post("longitude_2");
        $id    = $this->input->post("id_lokasi");
        $data  = [
            // 'master_plant_id'    => $plant,
            'nama_lokasi'        => $lokasi,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
        ];
        $save       = $this->admin->update($data, "master_lokasi", ['id' => $id]);
        if ($save >= 1) {
            $this->session->set_flashdata("ok", "Berhasil update data");
            redirect('PIC/Master/user');
        } else {
            $this->session->set_flashdata("nok", "Gagal update data");
            redirect('PIC/Master/user');
        }
    }
}
