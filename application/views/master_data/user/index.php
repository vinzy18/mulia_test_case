<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-success">Users</h6>
		</div>
		<div class="card-body">

			<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<p class="mb-0">
						<i class="fas fa-solid fa-check label-icon label-icon-success"></i>
						<?php echo $this->session->flashdata('success'); ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ($this->session->flashdata('error')): ?>
				<div class="alert alert-label alert-label-danger" role="alert">
					<p class="mb-0">
						<i class="mdi mdi-close label-icon label-icon-danger"></i>
						<strong>Whoops!</strong> There were some problems with your input.<br/>
						<?php echo $this->session->flashdata('error'); ?>
					</p>
				</div>
			<?php endif; ?>

			<div class="col-md-12 d-flex justify-content-end">
				<a class="btn btn-sm btn-secondary" href="<?= site_url('user/create') ?>">+ Add new user</a>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Fullname</th>
							<th>Username</th>
							<th>Email</th>
							<th>Is Vendor</th>
							<th>Created Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>


