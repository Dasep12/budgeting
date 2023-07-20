<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Laporan Per Kode Budget
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('departement/Reporting/perKodeBudget') ?>">
                    <div class="form-group">
                        <label>Departement</label>
                        <select id="departement" name="departement" class="form-control">
                            <?php foreach ($departement->result() as $dpt) : ?>
                                <option><?= $dpt->nama_departement ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <select id="tahun" name="tahun" class="form-control">
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = 22; $i <= 30; $i++) : ?>
                                <option value="<?= 20 . '' . $i ?>"><?= 20 . '' . $i ?></option>
                            <?php endfor ?>
                        </select>
                        <div id="load_kode" style="display:none ;">
                            <span class="text-danger font-italic small">mengambil kode budget . . .</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">KODE BUDGET</label>
                        <select id="kode_budget" name="kode_budget" class="form-control">
                            <option value="">Pilih Kode Budget</option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-sm">Download Report</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Laporan All Kode Budget
            </div>
            <div class="card-body">
                <form action="<?= base_url('departement/Reporting/allKodeBudget') ?>" method="post">
                    <div class="form-group">
                        <label>Departement</label>
                        <select id="departement_" name="departement_" class="form-control">
                            <?php foreach ($departement->result() as $dpt) : ?>
                                <option value="<?= $dpt->id ?>"><?= $dpt->nama_departement ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <select id="tahun_" name="tahun_" class="form-control">
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = 22; $i <= 30; $i++) : ?>
                                <option value="<?= 20 . '' . $i ?>"><?= 20 . '' . $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm">Download Report</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('select[name=tahun').on('change', function() {
        // $('#jenis_budget').prop('selectedIndex', 0);
        var tahun = $("select[name=tahun] option:selected").val();
        $.ajax({
            url: "<?= base_url('departement/Reporting/getKode') ?>",
            method: "POST",
            data: {
                tahun: tahun,
            },
            cache: false,
            beforeSend: function() {
                document.getElementById("load_kode").style.display = 'block';
            },
            complete: function() {
                document.getElementById("load_kode").style.display = 'none';
            },
            success: function(e) {
                var select1 = $('#kode_budget');
                select1.empty();
                var added2 = document.createElement('option');
                added2.value = "";
                added2.innerHTML = "Pilih Kode Budget";
                select1.append(added2);
                var result = JSON.parse(e);
                for (var i = 0; i < result.length; i++) {
                    var added = document.createElement('option');
                    added.value = result[i].kode_budget;
                    added.innerHTML = result[i].kode_budget;
                    select1.append(added);
                }
            }
        })
    })
</script>