<div class="timeline_approve">
    <div class="outer_approve">
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Dept Head</h5>
            </div>
            <?php if ($data->approve_mgr == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_mgr  == 1) { ?>
                <span>Approved on <?= $data->date_approved_mgr ?></span>
            <?php } else if ($data->approve_mgr  == 2) { ?>
                <span>Rejected on <?= $data->date_approved_mgr ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Budget Controller</h5>
            </div>
            <?php if ($data->approve_bc == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_bc  == 1) { ?>
                <span>Approved on <?= $data->date_approved_bc ?></span>
            <?php } else if ($data->approve_bc  == 2) { ?>
                <span>Rejected on <?= $data->date_approved_bc ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">General Manager</h5>
            </div>
            <?php if ($data->approve_gm == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_gm  == 1) { ?>
                <span>Approved on <?= $data->date_approved_gm ?></span>
            <?php } else if ($data->approve_gm  == 2) { ?>
                <span>Rejected on <?= $data->date_approved_gm ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Finance</h5>
            </div>
            <?php if ($data->approve_fin == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else if ($data->approve_fin == 1) { ?>
                <span>Approved on <?= $data->date_approved_finance ?></span>
            <?php } else if ($data->approve_fin == 2) { ?>
                <span>Rejected on <?= $data->date_approved_finance ?></span>
            <?php } ?>
        </div>
    </div>
</div>