<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Plant Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Plant Activity Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4 mb-2">PLANT BUDGET</h4>
        </div>
    </div>

    <form>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <select id="tahun_budget" name="tahun_budget" class="form-control">
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>KODE BUDGET</label>
                    <input readonly class="form-control" id="kode_budget" name="kode_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>BUDGET</label>
                    <input readonly class="form-control" id="budget" name="budget" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <label>ACTIVITY</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>JANUARI</label>
                    <input id="januari" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>FEBRUARI</label>
                    <input id="februari" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MARET</label>
                    <input id="maret" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>APRIL</label>
                    <input id="april" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>MEI</label>
                    <input id="mei" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>JUNI</label>
                    <input id="juni" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
            </div>
            <div class="col-lg-4">

                <div class="form-group">
                    <label>JULI</label>
                    <input id="juli" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>AGUSTUS</label>
                    <input id="agustus" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>SEPTEMBER</label>
                    <input id="september" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>OKTOBER</label>
                    <input id="oktober" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>NOVEMBER</label>
                    <input id="november" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>DESEMBER</label>
                    <input id="desember" name="bulan[]" class="form-control" type="text" placeholder="">
                </div>



                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>


    </form>


</div>