<div class="pd-20 card-box mb-30">
    <div class="justify-content-center">
        <div id="container"></div>
    </div>
</div>


<script>
    // Data retrieved from https://netmarketshare.com
    Highcharts.chart('container', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Budget ' + <?= date('Y') ?>,
            align: 'center'
        },

        accessibility: {
            point: {
                valueSuffix: ''
            }
        },
        tooltip: {
            formatter: function() {
                return formatRupiah(`${this.y}`, 'Rp.')
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 45,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}' + formatRupiah('', 'Rp.')
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Total',
            data: [{
                    name: 'Budget Planing',
                    y: <?= $plan_budget ?>,
                    color: '#0737f7',
                },
                {
                    name: 'Budget Terserap',
                    y: <?= $actual_budget ?>,
                    sliced: true,
                    color: '#f70737',
                },
            ]
        }]
    });

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
</script>