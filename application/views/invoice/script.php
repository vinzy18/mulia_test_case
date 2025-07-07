<script>
$(document).ready(function () {

	$('#dataTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "<?= site_url('invoice/index_data') ?>",
			"type": "POST",
		},
		"columnDefs": [{
			"targets": [0],
			"orderable": false,
			"width": 5
		}],
		
	});

	$('#dataTable').on('click', '.btn_confirm', function() {
		let id = +$(this).data('id');
		let inv_number = $(this).data('inv_number');
		
		Swal.fire({
			title: `You will confirm invoice ${inv_number}`,
			text: "You will not modificate any data of this invoice",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Confirm"
		})
		.then((result) => {
			if(result.isConfirmed){
				$.ajax({
					url: `<?= site_url('invoice/confirm/') ?>`+ id,
					method: "POST",
					data: {
						'is_confirmed': 1,
						'status': 'confirmed'
					},
					  dataType: 'json',
				})
				Swal.fire({
					title: "Thankyou!",
					text: "Your invoice has been confirmed.",
					icon: "success"
				});
	
				setTimeout(() => {
					window.location.reload();
				}, 1500)
			}
		});
	});

	$('#dataTable').on('click', '.btn_delete', function() {
		let id = +$(this).data('id');
		let inv_number = $(this).data('inv_number');
		
		Swal.fire({
			title: `Do you want to delete invoice ${inv_number}`,
			text: "All data will be deleted",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Confirm"
		})
		.then((result) => {
			if(result.isConfirmed){
				$.ajax({
					url: `<?= site_url('invoice/delete/') ?>`+ id,
					method: "POST",
					dataType: 'json',
				})
				Swal.fire({
					title: "Deleted",
					text: "Your invoice has been deleted.",
					icon: "success"
				});
				setTimeout(() => {
					window.location.reload();
				}, 1500)
			}
		});
	});

	function calculateTotals() {
		let totalQty = 0;
		let grandTotal = 0;

		$('#items-table tbody tr').each(function () {
			let qty = parseFloat($(this).find('.quantity').val()) || 0;
			let price = parseFloat($(this).find('.price').val()) || 0;
			let total = qty * price;

			$(this).find('.total').val(total);

			totalQty += qty;
			grandTotal += total;
		});

		$('#total-qty').val(totalQty.toLocaleString());
		$('#grand-total').val(grandTotal.toLocaleString());

		$('#total_qty').val(totalQty);
		$('#total_cost').val(grandTotal);
	}

	calculateTotals()
	
	$('#add-row').click(function () {
		let newRow = `
			<tr>
				<td><input type="text" name="item_name[]" class="form-control required" required></td>
				<td><input type="number" min="0" name="quantity[]" class="form-control required quantity" required></td>
				<td>
					<div class="input-group value">
                            <span class="input-group-text">Rp.</span>
							<input type="number" min="0" name="price[]" class="form-control required price" required></td>
					</div>
				</td>
				<td>
					<div class="input-group value">
							<span class="input-group-text">Rp.</span>
							<input type="number" name="total[]" class="form-control required total" readonly></td>
					</div>
				</td>
				<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-remove"><i class="fas fa-solid fa-trash"></i></button></td>
			</tr>
		`;
		$('#items-table tbody').append(newRow);
	});

	let deleted_ids = [];

	$('#items-table').on('click', '.btn-remove', function () {
		let id = $(this).data('item_id');
		if (id) {
			Swal.fire({
				title: `Old data will be deleted`,
				text: "Kindly double check it first",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Confirm"
			})
			.then((result) => {
				if(result.isConfirmed){
					deleted_ids.push(id);
					$(this).closest('tr').remove();
					calculateTotals();
				}
			})
		} else {
			$(this).closest('tr').remove();
			calculateTotals();
		}
	});

	$('#items-table').on('input', '.quantity, .price', function () {
		calculateTotals();
	});

	// $('#attachment').on('change', function(e) {
	// 	const file = e.target.files[0];

	// 	if (file && file.type.startsWith('image/')) {
	// 		const reader = new FileReader();
	// 		reader.onload = function(event) {
	// 			attachmentBase64 = event.target.result;

	// 			if ($('#base64_attachment').length === 0) {
	// 				$('<input>').attr({
	// 					type: 'hidden',
	// 					name: 'base64_attachment',
	// 					id: 'base64_attachment'
	// 				}).appendTo('#invoice-form');
	// 			}
	// 			$('#base64_attachment').val(attachmentBase64);
	// 		};
	// 		reader.readAsDataURL(file);
	// 	}
	// });

	$('#submit-invoice').on('click', function() {
		if (<?= $this->session->userdata('role_id') ?> != 3){
			Swal.fire({
				title: "Invalid",
				icon: "error",
				text: "You cannot submit invoice beacuse you are an admin",
				confirmButtonText: "Close",
			});
		} else {
			let error = false;
			let rowCount = $('#items-table tbody tr').length;
	
			$('#invoice-form').find('.required').each(function() {
				if (!$(this).val()) {
					error = true;
					return false;
				} else {
					$(this).css("border-color", "green");
				}
			});
			
			if (error == true || rowCount === 0) {
				if(error){
					$('#invoice-form').find('.required').each(function() {
						if(!$(this).val()){
							$(this).css("border-color", "red");
						} else {
							$(this).css("border-color", "green");
						}
					});
					Swal.fire({
						title: "Error!",
						icon: "error",
						text: "Please complete this form!",
						confirmButtonText: "Close",
					});
				} else if(rowCount === 0) {
					Swal.fire({
						title: "Invalid",
						icon: "error",
						text: "You have to add at least one (1) item",
						confirmButtonText: "Close",
					});
				}
			} else {
				Swal.fire({
					title: "Are you sure?",
					text: "Kindly check those data one last time",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Submit Invoice"
				})
				.then((result) => {
					if (result.isConfirmed) {
						Swal.fire({
							title: "Thankyou!",
							text: "Your invoice has been submited.",
							icon: "success"
						});
						deleted_ids.forEach(id => {
							$('<input>').attr({
								type: 'hidden',
								name: 'deleted_ids[]',
								value: id
							}).appendTo('#invoice-form');
						});
						setTimeout(() => {
							$('#invoice-form').submit()
						}, 1500)
					}
				});
			}
		}
	});

});
</script>
