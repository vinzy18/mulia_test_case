<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center m-3" href="<?= site_url('dashboard') ?>">
		<img src="<?= base_url('assets'); ?>/img/logo.png" alt="">
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
		<a class="nav-link" href="<?= site_url('dashboard') ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Billing Menu
	</div>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
			aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-fw fa-cog"></i>
			<span>Invoice</span>
		</a>
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<?php if ($this->session->userdata('role_id') != 2): ?>
					<a class="collapse-item" href="<?= site_url('invoice/create') ?>">Create new invoice</a>
				<?php endif; ?>
				<a class="collapse-item" href="<?= site_url('invoice') ?>">Invoices</a>
			</div>
		</div>
	</li>

	<?php if ($this->session->userdata('role_id') == 1): ?>
	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Master Data
	</div>

	<!-- Nav Item - Vendors -->
	<li class="nav-item">
		<a class="nav-link" href="<?= site_url('vendor') ?>">
			<i class="fas fa-fw fa-chart-area"></i>
			<span>Vendors</span></a>
	</li>

	<!-- Nav Item - Users -->
	<li class="nav-item">
		<a class="nav-link" href="<?= site_url('user') ?>">
			<i class="fas fa-fw fa-table"></i>
			<span>Users</span></a>
	</li>
	<?php endif; ?>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

	<!-- Sidebar Message -->
	<!-- <div class="sidebar-card d-none d-lg-flex">
		<img class="sidebar-card-illustration mb-2" src="assets/img/undraw_rocket.svg" alt="...">
		<p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
		<a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
	</div> -->

</ul>
<!-- End of Sidebar -->
