<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			
			<h6 class="m-0 font-weight-bold text-success"><a href="<?= site_url('vendor') ?>"><i class="fas fa-solid fa-arrow-left text-secondary text-sm"></i> </a> <?= $sub_title ?></h6>
		</div>
		<div class="card-body">
			<!-- @if ($message = Session::get('success'))
				<div class="alert alert-label alert-label-success" role="alert">
					<p class="mb-0">
						<i class="mdi mdi-check label-icon label-icon-success"></i>
						{{ $message }}
					</p>
				</div>
			@endif
			@if ($message = Session::get('errors'))
				<div class="alert alert-label alert-label-danger" role="alert">
					<p class="mb-0">
						<i class="mdi mdi-close label-icon label-icon-danger"></i>
						<strong>Whoops!</strong> There were some problems with your input.<br/>
						{{ $message }}
					</p>
				</div>
			@endif -->
			<div class="app-form rounded-control">
				<form action="<?= site_url('vendor/store') ?>" method="post">
					<div class="row">
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="col-form-label" for="vendor_code">Vendor Code</label>
								<input class="form-control" placeholder="Vendor Code will be genereting automatically" type="text" name="vendor_code" id="vendor_code" readonly>
							</div>
							<div class="mb-3">
								<label class="form-label" for="name">Vendor Name <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Enter Vendor Name" type="text" name="name" id="name" required>
							</div>
							<div class="mb-3">
								<label class="form-label" for="email">Email <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Enter Email" type="email" name="email" id="email"  required>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="form-label" for="join_date">Join Date <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Join Date" type="date" name="join_date" id="join_date" required>
							</div>
							<div class="mb-3">
								<label class="form-label" for="address">Address</label>
								<textarea name="address" class="form-control" id="address" rows="5" cols="40" placeholder="Enter Vendor's Address"></textarea>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<button class="btn btn-sm btn-success" type="submit" id="submit-vendor">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
