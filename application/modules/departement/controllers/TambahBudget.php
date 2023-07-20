<?php

class TambahBudget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'               => $this->uri->segment(2),
            'approve_mgr'       => $this->model->list_request("approve_mgr", $this->session->userdata("departement_id"), "mgr"),
            'approve_mgr2'       => $this->model->list_request("approve_mgr_2", $this->session->userdata("departement_id"), "mgr2"),
            'approve_bc'       => $this->model->list_request("approve_bc", $this->session->userdata("departement_id"), "bc"),
            'approve_gm'       => $this->model->list_request("approve_bc", $this->session->userdata("departement_id"), "gm"),
            'approve_fin'       => $this->model->list_request("approve_bc", $this->session->userdata("departement_id"), "fin"),
            'approve_spv'       => $this->model->list_request("approve_bc", $this->session->userdata("departement_id"), "spv")
        ];
        $this->template->load('template_departement', 'list_tambah_budget', $data);
    }

    public function form_request()
    {

        $data = [
            'uri'           => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget")->result(),
        ];
        $this->template->load('template_departement', 'tambah_budget', $data);
    }

    public function getKodeBudget()
    {
        $where = [
            'tahun'                  => $this->input->get("tahun"),
            'departement_id'         => $this->session->userdata("departement_id"),
            'master_jenis_budget_id' => $this->input->get("jenis")
        ];

        $data =  $this->model->ambilData("master_budget", $where);
        echo json_encode($data->result());
    }

    public function getBudget()
    {
        $dept = $this->session->userdata("departement_id");
        $tahun = $this->input->get("tahun");
        $bulan = $this->input->get("bulan");
        $kode = $this->input->get("kode");
        $data = $this->model->PlantBudgetDepartementPerBulan($dept, $tahun, $bulan, $kode);
        if ($data->num_rows() > 0) {
            $budget_p = $data->row();
            $detail = $this->model->getActualPlantBudgetBulanan($budget_p->id_planing);
            if ($detail->budget_actual == "" || $detail->budget_actual == null) {
                echo json_encode($data->row());
            } else {
                echo json_encode($detail);
            }
        } else {
            echo 0;
        }
    }

    public function input()
    {

        $id_planing     = $this->input->post("id_planning_budget");
        $budget_real    = $this->input->post("budget");
        $budget_request = $this->input->post("budget_request");
        $keperluan      = $this->input->post("keperluan");
        $data = [
            'master_planning_budget_id_planing'   => $id_planing,
            'master_departement_id'               => $this->session->userdata("departement_id"),
            'budget_sebelumnya'                   => $budget_real,
            'budget_request'                      => $budget_request,
            'created_at'                          => date('Y-m-d H:i:s'),
            'keperluan'                           => $keperluan,
            'created_by'                          => $this->session->userdata("nik"),
            'ket'                                 => 'menunggu approve supervisor',
        ];

        $upload =  $this->upload_multiple($_FILES['lampiran'], date('ymd'));
        $field_img = [];
        $nom = 1;
        foreach ($upload as $key => $item_file) {
            $field_img['lampiran_' . $nom] = $item_file['file_name'];
            $nom++;
        }

        $res_field = array_merge($data, $field_img);
        $save = $this->model->insert("transaksi_request_tambah_budget", $res_field);
        if ($save > 0) {
            $this->session->set_flashdata("ok", "Request tambah budget telah di ajukan");
            redirect('departement/TambahBudget');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/TambahBudget');
        }
    }

    private function upload_multiple($files, $title)
    {
        $config = array(
            'upload_path'   => './assets/lampiran/',
            'allowed_types' => 'jpg|png|jpeg|pdf',
            'overwrite'     => false,
        );

        $this->load->library('upload', $config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $img = array();
        foreach ($files['name'] as $key => $image) {
            if (!empty($files['name'][$key])) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                // $fileName = $title .'_'. $image;
                $rand_number = rand(10000, 99999);
                // $fileName = $title.'_'.$rand_number;
                $config['file_name'] = $title . '_' . date('YmdHis') . '_' . $rand_number;
                // $dok[] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $file = $this->upload->data();
                    $res[] = $file;
                } else {
                    $res = '01';
                    // $res = array('error' => $this->upload->display_errors());
                }
            }
        }

        return $res;
    }
}
