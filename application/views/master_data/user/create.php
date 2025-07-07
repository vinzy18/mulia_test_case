<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-success"><a href="<?= site_url('user') ?>"><i class="fas fa-solid fa-arrow-left text-secondary text-sm"></i> </a> <?= $sub_title ?></h6>
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
			<?php if ($this->session->flashdata('error')): ?>
				<div class="alert alert-label alert-label-danger" role="alert">
					<p class="mb-0">
						<i class="mdi mdi-close label-icon label-icon-danger"></i>
						<strong>Whoops!</strong> There were some problems with your input.<br/>
						<?php echo $this->session->flashdata('error'); ?>
					</p>
				</div>
			<?php endif; ?>
			<div class="app-form rounded-control">
				<form action="<?= site_url('user/store') ?>" method="post">
					<div class="row">
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="form-label" for="fullname">Fullname <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Enter Fullname" type="text" name="fullname" id="fullname" required>
							</div>
							<div class="mb-3">
								<label class="form-label" for="email">Email <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Enter Email" type="email" name="email" id="email"  required>
							</div>
							<div class="mb-3">
								<label class="form-label" for="role">Role <span class="text-danger">*</span></label>
								<select class="form-control" name="role_id" id="role_id">
									<option value="" selected></option>
									<?php foreach($roles as $role): ?>
										<?php if($role->id != 3):  ?>
											<option value="<?= $role->id ?>"><?= $role->name ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="form-label" for="username">Username <span class="text-danger">*</span></label>
								<input class="form-control" placeholder="Enter Username" type="text" name="username" id="username">
							</div>
							<div class="mb-3">
								<label class="form-label" for="password">Password <span class="text-danger">*</span></label>
								<input name="password" type="password" class="form-control" id="password" placeholder="Enter Password"></input>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<button class="btn btn-sm btn-success" type="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
