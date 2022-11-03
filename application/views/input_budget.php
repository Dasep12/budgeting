<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <!-- <h4 class="text-blue h4">Step wizard</h4> -->
        <p class="mb-30">Input Budget</p>
    </div>
    <div class="wizard-content">
        <form class="tab-wizard wizard-circle wizard">
            <h5>Step First</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Perusahaan :</label>
                            <select class="custom-select form-control">
                                <option value="">Select City</option>
                                <option value="Amsterdam">India</option>
                                <option value="Berlin">UK</option>
                                <option value="Frankfurt">US</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departemen :</label>
                            <select class="custom-select form-control">
                                <option value="">Select City</option>
                                <option value="Amsterdam">India</option>
                                <option value="Berlin">UK</option>
                                <option value="Frankfurt">US</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilihan Budget :</label>
                            <select class="custom-select form-control">
                                <option value="">Select City</option>
                                <option value="Amsterdam">India</option>
                                <option value="Berlin">UK</option>
                                <option value="Frankfurt">US</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tahun Anggaran:</label>
                            <select class="custom-select form-control">
                                <option value="">Select City</option>
                                <option value="Amsterdam">India</option>
                                <option value="Berlin">UK</option>
                                <option value="Frankfurt">US</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Step 2 -->
            <h5>Job Status</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>KPI :</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Target KPI :</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Improvement :</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Due Date :</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>PIC :</label>
                            <input type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Budget :</label>
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                </div>
            </section>

        </form>
    </div>
</div>

<!-- success Popup html Start -->
<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h3 class="mb-20">Form Submitted!</h3>
                <div class="mb-30 text-center">
                    <img src="<?= base_url('assets/') ?>vendors/images/success.png" />
                </div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                do eiusmod
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>
<!-- success Popup html End -->


<script>
    $(".tab-wizard").steps({
        headerTag: "h5",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit"
        },
        onStepChanged: function(event, currentIndex, priorIndex) {
            $('.steps .current').prevAll().addClass('disabled');
        },
        onFinished: function(event, currentIndex) {
            $('#success-modal').modal('show');
        }
    });
</script>