<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>LOGIN - E-BUDGETING</title>

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
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendors/styles/style.css" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
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
</head>

<body class="login-page">
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="<?= base_url('assets/src') ?>/images/Logo_login.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To E-Budgeting </h2>
                        </div>
                        <form onsubmit="return cek()" method="post" action="<?= base_url('Login/cek_login') ?>">
                            <div class="input-group custom">
                                <input type="text" id="user" class="form-control form-control-lg" placeholder="Username" name="user" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="**********" name="password" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">

                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">

                                    </div>
                                </div>
                            </div>
                            <?php if ($this->session->flashdata("fail")) : ?>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger">
                                            <p><?= $this->session->flashdata("fail") ?></p>
                                            <?php $this->session->unset_userdata("fail") ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="<?= base_url('assets/') ?>vendors/scripts/core.js"></script>
    <script src="<?= base_url('assets/') ?>vendors/scripts/script.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendors/scripts/process.js"></script>
    <script src="<?= base_url('assets/') ?>vendors/scripts/layout-settings.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script>
        function cek() {
            var user = document.getElementById("user").value;
            var password = document.getElementById("password").value;
            if (user == null || user == "") {
                alert("user name harus di isi")
                return false;
            } else if (password == null || password == "") {
                alert("password harus di isi ");
                return false;
            }
            return;
        }
    </script>
</body>

</html>