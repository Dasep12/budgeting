<?php


class Setting extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_pic', 'admin');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data = [
            'plant'          =>  $this->admin->show("master_plant")->result(),
            'lokasi_data'    => $this->admin->lokasi(),
            'lokasi_patrol'  => $this->admin->lokasi_patroli(),
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/setting", $data);
        $this->load->view("template/pic/footer");
    }

    public function input()
    {
        $lokasi = $this->input->post("lokasi");
        $count_err = 0;
        for ($i = 0; $i < count($lokasi); $i++) {
            $search = $this->db->get_where("transaksi_setting_patroli", ['master_lokasi_id' => $lokasi[$i]]);
            if ($search->num_rows() > 0) {
                $count_err += 1;
            }
        }

        if ($count_err > 0) {
            $this->session->set_flashdata("nok", "Data sudah ada");
            redirect('PIC/Setting');
        } else {
            $data = array();
            for ($j = 0; $j < count($lokasi); $j++) {
                array_push($data, array(
                    'master_lokasi_id' => $lokasi[$j],
                    'status'           => 0,
                    'created_at'       => date("Y-m-d H:i:s")
                ));
            }

            $save = $this->db->insert_batch("transaksi_setting_patroli", $data);
            if ($save) {
                $this->session->set_flashdata("ok", "Berhasil input data");
                redirect('PIC/Setting');
            } else {
                $this->session->set_flashdata("nok", "Data sudah ada");
                redirect('PIC/Setting');
            }
        }
    }
}
