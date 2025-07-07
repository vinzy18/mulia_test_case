<div class="container-fluid">

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-success"><?= $sub_title ?></h6>
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
			<div class="invoice-form rounded-control">
				<form action="<?= site_url('invoice/update') ?>" method="post" id="invoice-form">
					<div class="row mb-3">
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="form-label" for="vendor_code">Invoice Number</label>
								<input class="form-control" type="text" name="inv_number" id="inv_number" value="<?= $invoice->inv_number ?>" readonly>
								<input type="hidden" name="inv_id" id="inv_id" value="<?= $invoice->id ?>" readonly>
							</div>
							<div class="mb-3">
								<label class="form-label" for="period">Period <span class="text-danger">*</span></label>
								<input class="form-control required" placeholder="Enter Period" type="month" name="period" id="period" max="<?= date('Y-m') ?>" value="<?= date('Y-m', strtotime($invoice->period . '-01')) ?>" required readonly>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="mb-3">
								<label class="form-label" for="name">Vendor Name <span class="text-danger">*</span></label>
								<input class="form-control required" placeholder="Enter Vendor Name" type="text" name="vendor_name" id="vendor_name" value="<?= $vendor_name ?? null ?>" readonly>
								<input type="hidden" name="vendor_id" value="<?= $vendor_id ?>">
							</div>
							<div class="mb-3">
								<label class="form-label" for="post_date">Post Date <span class="text-danger">*</span></label>
								<input class="form-control required" placeholder="Post Date" type="date" name="post_date" id="post_date" max="<?= date('Y-m-d') ?>" value="<?= date($invoice->post_date) ?>" required readonly>
							</div> 
						</div>
					</div>

					<div class="card shadow mb-5">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-success">Items</h6>
						</div>
						<div class="card-body">
							<table class="table table-bordered" id="items-table">
								<thead>
									<tr>
										<th style="width: 55%;">Item Name <span class="text-danger">*</span></label></th>
										<th style="width: 10%;">Quantity <span class="text-danger">*</span></label></th>
										<th style="width: 15%;">Price <span class="text-danger">*</span></label></th>
										<th style="width: 15%;">Total <span class="text-danger">*</span></label></th>
										<th style="width: 5%;"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($items as $item): ?>
									<tr id="item_<?= $item->id ?>">
										<input type="hidden" name="item_id[]" value="<?= $item->id ?>">
										<td><input type="text" name="item_name_old[]" class="form-control required" value="<?= $item->item_name ?>" required></td>
										<td><input type="number" min="0" name="quantity_old[]" class="form-control required quantity" value="<?= $item->quantity ?>" required></td>
										<td>
											<div class="input-group value">
												<span class="input-group-text">Rp.</span>
												<input type="number" min="0" name="price_old[]" class="form-control required price" value="<?= $item->price ?>" required></td>
											</div>
										</td>
										<td>
											<div class="input-group value">
												<span class="input-group-text">Rp.</span>
												<input type="number" name="total_old[]" class="form-control required total" value="<?= $item->total ?>" readonly></td>
											</div>
										</td>
										<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-remove" data-item_id="<?= $item->id ?>"><i class="fas fa-solid fa-trash"></i></button></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<button type="button" id="add-row" class="btn btn-primary btn-sm">Add Item</button>

							<div class="row justify-content-end">
								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-6 col-form-label text-right">Total Quantity:</label>
										<div class="col-sm-6">
											<input type="text" id="total-qty" class="form-control required" readonly>
											<input type="hidden" id="total_qty" name="total_qty">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 col-form-label text-right">Grand Total:</label>
										<div class="input-group col-sm-6">
											<span class="input-group-text">Rp.</span>
											<input type="text" id="grand-total" class="form-control required" readonly>
											<input type="hidden" id="total_cost" name="total_cost">
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<?php if ($attachment): ?>
						<div class="mb-5">
							<h5>Attachment</h5>
							<img src="<?= $attachment->attachment_img ?>" width="300">
						</div>
					<?php endif; ?>
					
					<div class="col-md-6 mb-4">
						<button class="btn btn-sm btn-success" type="button" id="submit-invoice">Update Invoice</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
