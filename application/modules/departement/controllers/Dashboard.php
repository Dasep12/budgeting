<?php

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }
    public function index()
    {

        $kode = $this->db->query("SELECT kode_budget , budget as plant_budget ,
        ifnull((select sum(ammount) from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id  = tjp.id ),0)
        as actual_budget , (select (budget - actual_budget)) as sisa_budget
        from master_budget mb 
        inner join master_planning_budget mpb on mpb.master_budget_id_budget  = mb.id_budget 
        left join transaksi_jenis_pembayaran tjp on tjp.master_planning_budget_id_planing = mpb.id_planing 
        where departement_id = '" . $this->session->userdata("departement_id") . "'
        and mb.tahun = '" . date('Y') . "' and mb.approve_fin  = 1
        group by mb.kode_budget 
        ")->result_array();

        $kodeBudget = array();
        foreach ($kode as $key => $rso) {
            $kodeBudget[] = $rso['kode_budget'];
        }

        $plantBudget = array();
        foreach ($kode as $key => $rso) {
            $plantBudget[] = $rso['plant_budget'];
        }
        $actualBudget = array();
        foreach ($kode as $key => $rso) {
            $actualBudget[] = $rso['actual_budget'];
        }

        $sisaBudget = array();
        foreach ($kode as $key => $rso) {
            $sisaBudget[] = $rso['sisa_budget'];
        }

        $data = [
            'kode'           => json_encode($kodeBudget, true),
            'plant'           => json_encode($plantBudget, true),
            'actual'           => json_encode($actualBudget, true),
            'sisa'           => json_encode($sisaBudget, true),
            'uri'           => $this->uri->segment(2),
            'plan_budget'   => $this->model->totalPlaningBudget($this->session->userdata("departement_id")),
            'actual_budget' => $this->model->totalActualBudget($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'dashboard', $data);
    }
}
