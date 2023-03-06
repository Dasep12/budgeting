<div class="row">
    <div class="col-lg-12 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="plant_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 60; $i++) : ?>
                            <option <?= date('Y') == 20 . $i ? 'selected' : '' ?>>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="actual_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 60; $i++) : ?>
                            <option <?= date('Y') == 20 . $i ? 'selected' : '' ?>>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <canvas id="myChart2"></canvas>
                <center>
                    <h4>Actual Budget</h4>
                </center>
            </div>
        </div>
    </div> -->
</div>
<!-- <div class="row mt-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="actual_chart2" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 60; $i++) : ?>
                            <option <?= date('Y') == 20 . $i ? 'selected' : '' ?>>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="detail_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Departement</option>
                        <?php foreach ($dept->result() as $de) : ?>
                            <option value="<?= $de->id ?>"><?= $de->nama_departement ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <canvas id="detailChart"></canvas>
            </div>
        </div>
    </div>
</div> -->
<script>
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');
    const ctx3 = document.getElementById('detailChart');

    var plantGrafik = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Plant',
                data: <?= $plantTotal ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(150,90,20,0.9)'
            }, {
                label: 'Actual',
                data: <?= $plantTotal ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(200,120,120,0.9)'
            }]
        },
        options: {
            title: {
                display: true,
                text: "Chart.js Bar Chart - Stacked"
            },
        }
    });

    // var actualGrafik = new Chart(ctx2, {
    //     type: 'bar',
    //     data: {
    //         labels: <?= $depar ?>,
    //         datasets: [{
    //             label: 'Total',
    //             data: <?= $plantActual ?>,
    //             borderWidth: 1,
    //             backgroundColor: 'rgba(10,80,40,0.9)'
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    // var detailGrafik = new Chart(ctx3, {
    //     type: 'bar',
    //     data: {
    //         labels: ['', ''],
    //         datasets: [{
    //             label: 'Plan',
    //             backgroundColor: "rgba(168, 90, 50,1)",
    //             data: [0, 0],
    //         }, {
    //             label: 'Actual',
    //             backgroundColor: "rgba(50, 168, 80,1)",
    //             data: [0, 0],
    //         }, {
    //             label: 'Remain',
    //             backgroundColor: "rgba(110,20, 80,1)",
    //             data: [0, 0]
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    function ajaxPlantGrafik(tahun) {
        $.ajax({
            url: "<?= base_url('manager/Dashboard/getPlant') ?>",
            data: 'tahun=' + tahun,
            method: 'get',
            success: function(e) {
                let data = JSON.parse(e);
                // console.log(JSON.parse(data.plant));
                plantGrafik.data.datasets[0].data = JSON.parse(data.plant);
                plantGrafik.data.datasets[1].data = JSON.parse(data.actual);
                plantGrafik.update();
            }
        })
    }
    var tahun = $("select[name=plant_chart] option:selected").text();
    ajaxPlantGrafik(tahun)
    $('select[name=plant_chart').on('change', function() {
        var tahun = $("select[name=plant_chart] option:selected").text();
        ajaxPlantGrafik(tahun);
    })


    // function ajaxActualGrafik(tahun) {
    //     $.ajax({
    //         url: "<?= base_url('manager/Dashboard/getActual') ?>",
    //         data: 'tahun=' + tahun,
    //         method: 'get',
    //         success: function(e) {
    //             // console.log(JSON.parse(e));
    //             actualGrafik.data.datasets[0].data = JSON.parse(e);
    //             actualGrafik.update();
    //         }
    //     })
    // }
    // var tahun = $("select[name=actual_chart] option:selected").text();
    // ajaxActualGrafik(tahun);
    // $('select[name=actual_chart').on('change', function() {
    //     var tahun = $("select[name=actual_chart] option:selected").text();
    //     ajaxActualGrafik(tahun);
    // })



    // function ajaxDetailGrafik(tahun, departement) {
    //     $.ajax({
    //         url: "<?= base_url('manager/Dashboard/getDepartement') ?>",
    //         data: {
    //             tahun: tahun,
    //             dept: departement
    //         },
    //         method: 'POST',
    //         success: function(e) {
    //             let data = JSON.parse(e);
    //             // console.log(data);
    //             // console.log(data.kode);
    //             detailGrafik.data.datasets[0].data = data.plant;
    //             detailGrafik.data.datasets[1].data = data.actual;
    //             detailGrafik.data.datasets[2].data = data.sisa;
    //             detailGrafik.data.labels = data.kode;
    //             detailGrafik.update();
    //         }
    //     })
    // }
    // var tahun = $("select[name=actual_chart2] option:selected").text();
    // var dept = $("select[name=detail_chart] option:selected").val();
    // ajaxDetailGrafik(tahun, dept);
    // $('select[name=actual_chart2],select[name=detail_chart]').on('change', function() {
    //     var tahun = $("select[name=actual_chart2] option:selected").text();
    //     var dept = $("select[name=detail_chart] option:selected").val();
    //     ajaxDetailGrafik(tahun, dept);
    // })
</script>