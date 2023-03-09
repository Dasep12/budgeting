<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="plant_chart" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 30; $i++) : ?>
                            <option>20<?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="actual_chart2" class="form-control form-control-sm" id="">
                        <option value="">Choose Year</option>
                        <?php for ($i = 21; $i < 30; $i++) : ?>
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
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    const ctx = document.getElementById('myChart');
    const ctx3 = document.getElementById('myChart2');

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    const topLabels = {
        id: 'topLabels',
        afterDatasetDraw(chart, args, pluginOptions) {
            const {
                ctx,
                scales: {
                    x,
                    y
                }
            } = chart;
            chart.data.datasets[0].data.forEach((datapoint, index) => {
                const datasetArray = [];
                chart.data.datasets.forEach((dataset) => {
                    datasetArray.push(dataset.data[index])
                })

                function totalSum(total, values) {
                    return total + values;
                }
                let sum = datasetArray.reduce(totalSum, 0)
                ctx.font = 'bold 12px sans-serif';
                ctx.fillStyle = 'rgba(255,26,104,1)';
                ctx.textAlign = "center";
                ctx.fillText(sum, y.getPixelForValue(index), chart.getDatasetMeta(1).data[index].y - 10)
            })
        }
    }
    var plantBudget = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Plant',
                datalabels: {
                    color: 'black'
                },
                data: <?= $plantBudget ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(200,120,40,0.9)'
            }, {
                label: 'Actual',
                datalabels: {
                    color: 'red'
                },
                data: <?= $actualBudget ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(10,190,20,0.9)'
            }]
        },
        options: {
            indexAxis: 'y',

        },
        // plugins: [ChartDataLabels]
    });

    var detailGrafik = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['', ''],
            datasets: [{
                label: 'Plan',
                backgroundColor: "rgba(168, 90, 50,1)",
                data: [0, 0],
            }, {
                label: 'Actual',
                backgroundColor: "rgba(50, 168, 80,1)",
                data: [0, 0],
            }, {
                label: 'Remain',
                backgroundColor: "rgba(110,20, 80,1)",
                data: [0, 0]
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
            url: "<?= base_url('gm/Dashboard/getPlant') ?>",
            data: 'tahun=' + tahun,
            method: 'get',
            success: function(e) {
                // console.log(JSON.parse(e));
                let data = JSON.parse(e);
                plantBudget.data.datasets[0].data = JSON.parse(data.plant);
                plantBudget.data.datasets[1].data = JSON.parse(data.actual);
                plantBudget.update();
            }
        })
    })



    function ajaxDetailGrafik(tahun, departement) {
        $.ajax({
            url: "<?= base_url('gm/Dashboard/getDepartement') ?>",
            data: {
                tahun: tahun,
                dept: departement
            },
            method: 'POST',
            success: function(e) {
                let data = JSON.parse(e);
                // console.log(data);
                // console.log(data.kode);
                detailGrafik.data.datasets[0].data = data.plant;
                detailGrafik.data.datasets[1].data = data.actual;
                detailGrafik.data.datasets[2].data = data.sisa;
                detailGrafik.data.labels = data.kode;
                detailGrafik.update();
            }
        })
    }
    var tahun = $("select[name=actual_chart2] option:selected").text();
    var dept = $("select[name=detail_chart] option:selected").val();
    ajaxDetailGrafik(tahun, dept);
    $('select[name=actual_chart2],select[name=detail_chart]').on('change', function() {
        var tahun = $("select[name=actual_chart2] option:selected").text();
        var dept = $("select[name=detail_chart] option:selected").val();
        ajaxDetailGrafik(tahun, dept);
    })
</script>