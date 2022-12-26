<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="plant_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 60; $i++) : ?>
                            <option>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <canvas id="myChart"></canvas>
                <center>
                    <h4>Planing Budget</h4>
                </center>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="actual_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 60; $i++) : ?>
                            <option>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <canvas id="myChart2"></canvas>
                <center>
                    <h4>Actual Budget</h4>
                </center>
            </div>
        </div>
    </div>

</div>

<script>
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');

    var plantBudget = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Total',
                data: <?= $plantBudget ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(200,120,40,0.9)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var actualBudget = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Total',
                data: <?= $actualBudget ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(10,80,40,0.9)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    $('select[name=plant_chart').on('change', function() {
        var tahun = $("select[name=plant_chart] option:selected").text();
        $.ajax({
            url: "<?= base_url('budgetControl/Dashboard/getPlant') ?>",
            data: 'tahun=' + tahun,
            method: 'get',
            success: function(e) {
                console.log(JSON.parse(e));
                plantBudget.data.datasets[0].data = JSON.parse(e);
                plantBudget.update();
            }
        })
    })

    $('select[name=actual_chart').on('change', function() {
        var tahun = $("select[name=actual_chart] option:selected").text();
        $.ajax({
            url: "<?= base_url('budgetControl/Dashboard/getActual') ?>",
            data: 'tahun=' + tahun,
            method: 'get',
            success: function(e) {
                console.log(JSON.parse(e));
                actualBudget.data.datasets[0].data = JSON.parse(e);
                actualBudget.update();
            }
        })
    })
</script>