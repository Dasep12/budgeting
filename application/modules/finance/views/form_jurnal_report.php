<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Report</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Jurnal Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">

    </div>

    <form action="<?= base_url('finance/Jurnal/download') ?>" method="post">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Departement</label>
                    <select id="departement" name="departement" class="form-control">
                        <option value="">Pilih Departement</option>
                        <?php foreach ($departement->result() as $dpt) : ?>
                            <option value="<?= $dpt->id ?>"><?= $dpt->nama_departement ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" id="tanggal" name="tanggal" class="form-control">
                </div>
            </div>
            <div class="col-lg-3 mt-4 ">
                <label for=""></label>
                <button id="filter" class="text-white btn btn-success mt-2">download</button>
            </div>
        </div>
    </form>
</div>


<script>
    $(function() {
        moment.locale('id'); // id
        var start = moment().subtract(2, 'days');
        var end = moment();
        $('input[name="tanggal"]').daterangepicker({
            opens: 'left',
            "autoApply": true,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
                '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            },
            "locale": {
                format: 'YYYY-M-D',
                "separator": " sd ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "Dari",
                "toLabel": "Sampai",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Augustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
            },
            "alwaysShowCalendars": true,
            "startDate": start,
            "endDate": end,
            "opens": "center",
            "drops": "auto"
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        }, );
    })
</script>