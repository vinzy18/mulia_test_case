
<script>
  	$(document).ready(function() {
		$('#dataTable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?= site_url('vendor/index_data') ?>",
				"type": "POST",
			},
			"columnDefs": [{
				"targets": [0],
				"orderable": false,
				"width": 5
			}],
		});

		$('#dataTable').on('click', '.btn-generate-user', function() {
            let fullname = $(this).data('fullname');
            let email = $(this).data('email');
            let vendor_id = $(this).data('vendor_id');
			
            $('#generateUserModal').modal('show');

			$('#fullname').val(fullname)
			$('#email').val(email)
			$('#vendor_id').val(vendor_id)
        });

		// $('#submit-vendor').on('click', function() {
		// 	Swal.fire({
		// 		title: "Are you sure?",
		// 		text: "Kindly check those data one last time",
		// 		icon: "warning",
		// 		showCancelButton: true,
		// 		confirmButtonColor: "#3085d6",
		// 		cancelButtonColor: "#d33",
		// 		confirmButtonText: "Submit"
		// 		})
		// 		.then((result) => {
		// 			$.ajax({
		// 				url: 
		// 			})
		// 			if (result.isConfirmed) {
		// 				Swal.fire({
		// 				title: "Deleted!",
		// 				text: "Your file has been deleted.",
		// 				icon: "success"
		// 				});
		// 			}
		// 		});
		// })
	})
</script>
