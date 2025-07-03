<script>
  	$(document).ready(function() {
		$('#dataTable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?= site_url('user/index_data') ?>",
				"type": "POST",
			},
			"columnDefs": [{
				"targets": [0],
				"orderable": false,
				"width": 5
			}],
			
		});
	})
</script>
