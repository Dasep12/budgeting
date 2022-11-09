<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        Actual Budget
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Actual Activity Budget
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4 mb-2">ACTUAL BUDGET</h4>
        </div>
    </div>

    <form>
        <div class="row">
            <div class="col-lg-6">
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


            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>BULAN</label>
                    <select id="bulan_budget" name="bulan_budget" class="form-control">
                        <option>JANUARI</option>
                        <option>FEBRUARI</option>
                        <option>MARET</option>
                        <option>APRIL</option>
                        <option>MEI</option>
                        <option>JUNI</option>
                        <option>JULI</option>
                        <option>AGUSTUS</option>
                        <option>SEPTEMBER</option>
                        <option>OKTOBER</option>
                        <option>NOVEMBER</option>
                        <option>DESEMBER</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>ACTIVITY</label>
                    <textarea id="activity" name="activity" class="form-control" placeholder=""></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>


    </form>


</div>