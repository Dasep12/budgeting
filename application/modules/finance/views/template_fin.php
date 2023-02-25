<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>E-Budgeting</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/') ?>vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/') ?>vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/') ?>vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendors/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>src/plugins/jquery-steps/jquery.steps.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendors/styles/icon-font.min.css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <!-- js -->
    <script src="<?= base_url('assets/') ?>vendors/scripts/core.js"></script>

    <script src="<?= base_url('assets/') ?>vendors/scripts/process.js"></script>
    <script src="<?= base_url('assets/') ?>vendors/scripts/layout-settings.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/jquery-steps/jquery.steps.js"></script>
    <!-- <script src="<?= base_url('assets/') ?>vendors/scripts/steps-setting.js"></script> -->
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <!-- <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script> -->
    <!-- buttons for Export datatable -->
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/vfs_fonts.js"></script>
    <script src="<?= base_url('assets/') ?>src/plugins/apexcharts/apexcharts.min.js"></script>
    <!-- Datatable Setting js -->
    <script src="<?= base_url('assets/') ?>vendors/scripts/datatable-setting.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="<?= base_url('assets/') ?>vendors/images/deskapp-logo.svg" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> -->

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>

        </div>
        <div class="header-right">
            <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div>

            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/640px-User_icon_2.svg.png" alt="" />
                        </span>
                        <span class="user-name"><?= ucwords($this->session->userdata("nama")) ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="<?= base_url('finance/Password/') ?>"><i class="dw dw-settings2"></i> Ganti Password</a>
                        <a class="dropdown-item" href="<?= base_url('Logout') ?>"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="#">
                <img style="height:90px;width:250px" src="<?= base_url('assets/') ?>src/images/pim_logo.jpeg" alt="" class="dark-logo" />
                <img style="height:90px;width:250px" src="<?= base_url('assets/') ?>src/images/pim_logo.jpeg" alt="" class="light-logo" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li class="dropdown">
                        <a href="<?= base_url('finance/Dashboard') ?>" class="dropdown-toggle no-arrow <?= $uri == 'Dashboard' ? 'active' : '' ?>">
                            <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-file"></span><span class="mtext">E-Budget</span>
                        </a>
                        <ul class="submenu">
                            <li><a class="<?= $this->uri->segment(3) == 'list_approve_req' ? 'active ' : '' ?>" href="<?= base_url('finance/ApproveRequestTambah/list_approve_req') ?>">Approve Tambah Budget</a></li>
                            <li><a class="<?= $this->uri->segment(3) == 'list_approve' ? 'active ' : '' ?>" href="<?= base_url('finance/Approved/list_approve') ?>">Approved Plant Budget</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-file"></span><span class="mtext">Transaksi</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a class="<?= $this->uri->segment(3) == 'list_approve_trans' ? 'active ' : '' ?>" href="<?= base_url('finance/Approve_trans/list_approve_trans') ?>">Approval</a>
                            </li>
                            <li>
                                <a class="<?= $this->uri->segment(3) == 'histori_approve_trans' ? 'active ' : '' ?>" href="<?= base_url('finance/Approve_trans/histori_approve_trans') ?>">History</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-file"></span><span class="mtext">AP-Voucher</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a class="<?= $this->uri->segment(3) == 'list_approveVoucher' ? 'active ' : '' ?>" href="<?= base_url('finance/Approve_voucher/list_approveVoucher') ?>">Approve Plant</a>
                            </li>
                            <li>
                                <a class="<?= $this->uri->segment(3) == 'list_approve_lapor' ? 'active ' : '' ?>" href="<?= base_url('finance/Approve_voucher/list_approve_lapor') ?>">Approve Lapor Voucher</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-file-pdf"></span><span class="mtext">Laporan</span>
                        </a>
                        <ul class="submenu">
                            <li><a class="<?= $this->uri->segment(3) == 'panjer' ? 'active ' : '' ?>" href="<?= base_url('finance/Laporan/panjer') ?>">Panjar</a></li>
                            <li><a class="<?= $this->uri->segment(3) == 'payment' ? 'active ' : '' ?>" href="<?= base_url('finance/Laporan/payment') ?>">Payment Voucher</a></li>
                            <li><a class="<?= $this->uri->segment(2) == 'ReportBudget' ? 'active ' : '' ?>" href="<?= base_url('finance/ReportBudget') ?>">Plant Budget</a></li>
                            <li><a class="<?= $this->uri->segment(2) == 'Jurnal' ? 'active ' : '' ?>" href="<?= base_url('finance/Jurnal') ?>">Jurnal</a></li>
                            <li><a class="<?= $this->uri->segment(3) == 'apvoucher' ? 'active ' : '' ?>" href="<?= base_url('finance/Laporan/apvoucher') ?>">AP Voucher</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Simple Datatable start -->
                <?= $contents ?>

                <!-- end datatable -->

            </div>
            <!-- <div class="footer-wrap pd-20 mb-20 card-box">
                DeskApp - Bootstrap 4 Admin Template By
                <a href="https://github.com/dropways" target="_blank">Ankit Hingarajiya</a>
            </div> -->
        </div>
    </div>

</body>

<script src="<?= base_url('assets/') ?>vendors/scripts/script.min.js"></script>

</html>