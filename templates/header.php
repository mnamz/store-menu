<?php 
include_once 'db.php'; 
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dronecare</title>

	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-buttons-dt/css/buttons.dataTables.css">

</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="index3.html" class="brand-link">
				<!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
				<span class="brand-text font-weight-light">Dronecare</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
						data-accordion="false">
						<!-- Dashboard -->
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-th"></i>
								<p>Dashboard</p>
							</a>
						</li>

						<!-- Users -->
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-users"></i>
								<p>Users</p>
							</a>
						</li>

						<!-- Categories -->
						<li class="nav-item">
							<a href="categories.php" class="nav-link">
								<i class="nav-icon fas fa-list"></i>
								<p>Categories</p>
							</a>
						</li>

						<!-- Product -->
						<li class="nav-item">
							<a href="products.php" class="nav-link">
								<i class="nav-icon fas fa-box"></i>
								<p>Product</p>
							</a>
						</li>

						<!-- Menu List -->
						<li class="nav-item">
							<a href="/" class="nav-link">
								<i class="nav-icon fas fa-bars"></i>
								<p>Menu List</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>