<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I - SECURITY</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/assets/dist/img/logo.jpeg">

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/buttons.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css?<?= date('Y-m-d H:i:s') ?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	<!-- jQuery -->
	<script src="<?= base_url('assets') ?>/dist/js/jquery.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets') ?>/dist/js/sweetalert2.all.min.js"></script>

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

	<!-- pagination freeze -->
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/select2/css/select2.min.css">

	<!--  -->
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>
	<!-- filtter -->
	<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>

	<!-- tags input -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/dist/css/jquery-tagsinput.min.css" />
	<script src="<?= base_url('assets') ?>/dist/js/jquery-tagsinput.min.js" defer></script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-dark navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<a href="<?= base_url('Menu') ?>" class="btn btn-primary btn-sm"><i class="fas fa-home"></i></a>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto text-white">
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item mr-2">
					<span class="font-italic font-bold">Welcome <?= $user->nama ?></span>
				</li>
				<li class="nav-item">
					<a class=" btn btn-sm btn-info" href="<?= base_url('Logout') ?>">
						<i class="fas fa-user"></i> LOGOUT
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->
		<aside class="main-sidebar sidebar-dark-info elevation-4">
			<!-- Brand Logo -->
			<a href="<?= base_url('assets') ?>/index3.html" class="brand-link">
				<img src="<?= base_url('assets') ?>/dist/img/logo.jpeg" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

				<label style="margin-left:-5px" class="brand-text font-bold font-weight-light"><b>Astra Daihatsu
						Motor</b></label>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="<?= base_url('assets') ?>/dist/img/security.png" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">I - SECURITY</a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		
						<li class="nav-item ">
							<a href="<?= base_url('isecurity_contractor/HomeCoy') ?>" class="nav-link active">
								<i class="nav-icon fas fa-tachometer-alt "></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>
						
						<?php if(($user->security_operation) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Security Operational
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Tamu') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Tamu</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Kendaraan') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Kendaraan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Barang') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Barang</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Outsourching') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Outsourching</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Patroli') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Patroli</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/Kontraktor') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Kontraktor</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/LaporanHarian') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Harian</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecOps/LaporanKejadian') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Kejadian</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Kehilangan</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Dokumen</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Memo Security</p>
									</a>
								</li>
						
							</ul>
						</li>
						<?php } ?>
						
						<?php if(($user->security_admin) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Security Admin
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecAdm/DataAnggota') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Anggota</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecAdm/Inventaris') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Inventaris</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecAdm/Pembelian') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Pembelian</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/SecAdm/Budget') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Budget</p>
									</a>
								</li>
						
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->security_information) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
								Security Information
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>News Paper</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Security & Tips</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Emergency News</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Hot News</p>
									</a>
								</li>
						
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->training) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
								SGDP
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Materi</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Schedule</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Nilai</p>
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->asms) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									ASMS
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Checklist</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Pemenuhan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Undang Undanga</p>
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->atsg) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									ATSG
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Checklist</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Pemenuhan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Undang Undanga</p>
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->smp) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									SMP
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Checklist</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Pemenuhan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('#') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Undang Undanga</p>
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>

						<?php if(($user->control_database) == 1 ) { ?>
						<li class="nav-item ">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Control Database
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Perusahaan') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Perusahaan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Kendaraan') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Kendaraan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Karyawan') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Karyawan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Tamu') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Tamu</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Outsourching') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Outsourching</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/Kontraktor') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>Kontraktor</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url('isecurity_contractor/Cd/User') ?>" class="nav-link ">
										<i class="far fa-circle nav-icon"></i>
										<p>User</p>
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->