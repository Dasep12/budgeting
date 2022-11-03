<div class="card-box mb-30">
    <div class="pd-20">
        <!-- <h4 class="text-blue h4">Data Table Simple</h4> -->
    </div>
    <div class="pb-20">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-30">
                <div class="pd-20 card-box height-50-p">
                    <h4 class="h4 text-blue">BUDGET TAHUN BERJALAN</h4>
                    <div id="chart8"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var options8 = {
        series: [44, 55, 41, 17, 15],
        chart: {
            type: 'donut',
        },
        responsive: [{
            breakpoint: 10,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chart8"), options8);
    chart.render();
</script>