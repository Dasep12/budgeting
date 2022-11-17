<?php


class Input_Budget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
    }

    public function index()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'jenis'     => $this->model->getData("master_jenis_budget")->result()
        ];
        $this->template->load('template_departement', 'input_budget', $data);
    }


    public function input()
    {
        $tahun  = $this->input->post("tahun_budget");
        $kode  = $this->input->post("kode_budget");
        $jenis  = $this->input->post("jenis_budget");
        $kpi  = $this->input->post("kpi");
        $target_kpi  = $this->input->post("target_kpi");
        $pic = $this->input->post("pic");
        $improvement = $this->input->post("improvement");
        $budget = $this->input->post("budget");
        $account_bame = $this->input->post("account_bame");
        $description = $this->input->post("description");

        $data = [
            'tahun'                     => $tahun,
            'kode_budget'               => $kode,
            'master_jenis_budget_id'    => $jenis,
            'target_kpi'                => $target_kpi,
            'pic'                       => $pic,
            'kpi'                       => $kpi,
            'improvment'                => $improvement,
            'budget'                    => $budget,
            'description'               => $description,
            'account_bame'              => $account_bame,
            'created_at'                => date('Y-m-d H:i:s'),
            'departement_id'            => $this->session->userdata("departement_id"),
            'status'                    => 0,
            'created_by'                => $this->session->userdata("nik")
        ];

        $save =  $this->model->insert("master_budget", $data);
        if ($save) {
            $this->session->set_flashdata("ok", "Budget di ajukan , menunggu approval");
            redirect('departement/Input_Budget');
        } else {
            $this->session->set_flashdata("fail", "gagal input");
            redirect('departement/Input_Budget');
        }
    }
}
