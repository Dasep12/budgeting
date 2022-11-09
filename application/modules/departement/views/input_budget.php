<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        Input Budget
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
            <div class="col-lg-6">
                <div class="form-group">
                    <label>TAHUN BUDGET</label>
                    <input class="form-control" id="tahun_budget" name="tahun_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>KODE BUDGET</label>
                    <input class="form-control" id="kode_budget" name="kode_budget" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>JENIS BUDGET</label>
                    <select id="jenis_budget" name="jenis_budget" class="form-control">
                        <option>Regular Cost</option>
                        <option>Perspective Cost</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>KPI</label>
                    <input id="kpi" name="kpi" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>TARGET KPI</label>
                    <input id="target_kpi" name="target_kpi" class="form-control" type="text" placeholder="">
                </div>
                <div class="form-group">
                    <label>PIC</label>
                    <input id="pic" name="pic" class="form-control" type="text" placeholder="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>IMPROVEMENT</label>
                    <textarea id="improvement" name="improvement" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>BUDGET</label>
                    <input id="budget" name="budget" class="form-control" type="text" placeholder="">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </div>
            </div>
        </div>


    </form>


</div>