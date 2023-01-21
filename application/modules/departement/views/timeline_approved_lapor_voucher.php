<div class="timeline_approve">
    <div class="outer_approve">
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Supervisor</h5>
            </div>
            <?php if ($data->approve_lapor_spv == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_lapor_spv  == 1) { ?>
                <span>Approved on <?= $data->date_lapor_spv ?></span>
            <?php } else if ($data->approve_lapor_spv  == 2) { ?>
                <span>Rejected on <?= $data->date_lapor_spv ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Dept Head</h5>
            </div>
            <?php if ($data->approve_lapor_mgr == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_lapor_mgr  == 1) { ?>
                <span>Approved on <?= $data->date_lapor_mgr ?></span>
            <?php } else if ($data->approve_lapor_mgr  == 2) { ?>
                <span>Rejected on <?= $data->date_lapor_mgr ?></span>
            <?php } ?>
        </div>

        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Budget Controller</h5>
            </div>
            <?php if ($data->approve_lapor_bc == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_lapor_bc  == 1) { ?>
                <span>Approved on <?= $data->date_lapor_bc ?></span>
            <?php } else if ($data->approve_lapor_bc  == 2) { ?>
                <span>Rejected on <?= $data->date_lapor_bc ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">General Manager</h5>
            </div>
            <?php if ($data->approve_lapor_gm == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_lapor_gm   == 1) { ?>
                <span>Approved on <?= $data->date_lapor_gm ?></span>
            <?php } else if ($data->approve_lapor_gm  == 2) { ?>
                <span>Rejected on <?= $data->date_lapor_gm ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Finance</h5>
            </div>
            <?php if ($data->approve_lapor_fin == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_lapor_fin == 1) { ?>
                <span>Approved on <?= $data->date_lapor_fin ?></span>
            <?php } else if ($data->approve_lapor_fin == 2) { ?>
                <span>Rejected on <?= $data->date_lapor_fin ?></span>
            <?php } ?>
        </div>
    </div>
</div>