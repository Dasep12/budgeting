<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Report</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Payment
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">

    </div>

    <form action="<?= base_url('gm/Laporan/getPayment') ?>" method="post" onsubmit="return cek()">
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
                    <label>Jenis Transaksi</label>
                    <select id="jenis_trans" name="jenis_trans" class="form-control">
                        <?php foreach ($jenis->result() as $jns) : ?>
                            <option selected value="<?= $jns->id ?>"><?= $jns->jenis_transaksi ?></option>
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
            <div class="col-lg-3 mt-4">
                <label for=""></label>
                <button type="button" id="filter" class="btn btn-primary mt-1">view</button>
            </div>
        </div>
    </form>
</div>

<div class="pd-20 card-box mb-30">
    <div class="form-inline">
        <!-- <a href="" class="btn btn-sm btn-danger"><span class="micon bi bi-file-pdf"></span></a>
        <a href="" class="btn btn-sm btn-success ml-2"><span class="micon bi bi-file-excel"></span> </a> -->
    </div>
    <div class="card-body">
        <table id="paymentTable" style="width: 100%;" class="table table-sm">
            <thead>
                <tr>
                    <!-- <th>No</th> -->
                    <th>Kode Request</th>
                    <th>Tanggal</th>
                    <th>Particullar</th>
                    <th>Ammount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
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
                format: 'D/M/YYYY',
                "separator": " - ",
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


        let tablePayment = $('#paymentTable').DataTable({
            paging: true,
            scrollX: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            // autoWidth: true,
            processing: true,
            serverSide: false,
            dom: 'Bfrtip',
            buttons: ['csv', 'excel'],
            ajax: {
                url: "<?= base_url('gm/Laporan/list_payment') ?>",
                dataSrc: '',
                data: function() {
                    var drp = $('#tanggal').data('daterangepicker');
                    var param = {
                        'start': drp.startDate.format('YYYY-MM-DD'),
                        'end': drp.endDate.format('YYYY-MM-DD'),
                        'deptId': $('#departement').find(":selected").val(),
                        'jenis': $('#jenis_trans').find(":selected").val(),
                    }
                    return param
                }
            },
            pageLength: 25,
            columns: [{
                    data: 'request_code'
                },
                {
                    data: 'tanggal_request'
                },
                {
                    data: 'remarks'
                },
                {
                    data: 'ammount'
                },
                {
                    data: 'particullar'
                }
            ]
        });

        $('#filter').click(function() {
            tablePayment.ajax.reload();
        })
    });
</script>