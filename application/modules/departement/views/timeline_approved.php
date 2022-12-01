<div class="timeline_approve">
    <div class="outer_approve">
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Manager</h5>
            </div>
            <?php if ($data->approve_mgr == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else { ?>
                <span>Approved on <?= $data->approved_mgr ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Budget Controller</h5>
            </div>
            <?php if ($data->approve_bc == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else { ?>
                <span>Approved on <?= $data->approved_bc ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">General Manager</h5>
            </div>
            <?php if ($data->approve_gm == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else { ?>
                <span>Approved on <?= $data->approved_gm ?></span>
            <?php } ?>
        </div>
        <div class="card_approve">
            <div class="info_approve">
                <h5 class="title_approve">Finance</h5>
            </div>
            <?php if ($data->approve_fin == 0) { ?>
                <span>Menunggu Approved</span>
            <?php } else { ?>
                <span>Approved on <?= $data->approved_fin ?></span>
            <?php } ?>
        </div>
    </div>
</div>