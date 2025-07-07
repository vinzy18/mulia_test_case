<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-success">Vendors</h6>
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
				<a class="btn btn-sm btn-secondary" href="<?= site_url('vendor/create') ?>">+ Add new vendor</a>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Vendor Name</th>
							<th>Code</th>
							<th style="width: 60px;">Address</th>
							<th>Email</th>
							<th>Join Date</th>
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

	<!-- Generate User modal -->
	<div class="modal fade" id="generateUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<form action="<?= site_url('vendor/generate_user') ?>" method="post">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Generating User</h5>
			<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="app-form rounded-control">
				<div class="row">
					<div class="col-md-6 mb-4">
						<div class="mb-3">
							<label class="form-label" for="username">Username <span class="text-danger">*</span></label>
							<input class="form-control" placeholder="Enter Username" type="text" name="username" id="username">
						</div>
					</div>
					<div class="col-md-6 mb-4">
						<div class="mb-3">
							<label class="form-label" for="password">Password <span class="text-danger">*</span></label>
							<input name="password" type="password" class="form-control" id="password" placeholder="Enter Password"></input>
						</div>
						<input type="hidden" name="fullname" id="fullname">
						<input type="hidden" name="email" id="email">
						<input type="hidden" name="vendor_id" id="vendor_id">
						<input type="hidden" name="is_vendor" id="is_vendor" value="on">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success">Generate</button>
		</div>
		</div>
	</form>
	</div>
	</div>
</div>
