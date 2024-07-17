<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeIgniter Ajax Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  </head>
  <body>
		<div class="container">
			<div class="row">
				<div class="col-md-12 mt-5">
					<h1 class="text-center">CodeIgniter Ajax Crud</h1>
					<hr style="background-color: black;color: black;height: 1px;">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-5">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
						Add Records
					</button>

					<!-- Insert Modal -->
					<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="addModalLabel">Add Record</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form action="" method="POST" id="form">
										<div class="form-group">
											<label for="">Name</label>
											<input type="text" name="name" id="name" class="form-control">
										</div>
										<div class="form-group">
											<label for="">Email</label>
											<input type="text" name="email" id="email" class="form-control">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" id="add">Add</button>
								</div>
							</div>
						</div>
					</div>

					<!-- Edit Modal -->
					<div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="editModelLabel">Edit Record</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form action="" method="POST" id="edit_form">
										<input type="hidden" id="edit_id" value="">
										<div class="form-group">
											<label for="">Name</label>
											<input type="text" name="edit_name" id="edit_name" class="form-control">
										</div>
										<div class="form-group">
											<label for="">Email</label>
											<input type="text" name="edit_email" id="edit_email" class="form-control">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" id="update">Update</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-3">
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<!-- <tbody>
							<?php  
							foreach ($users as $user) {
							?>
								<tr>
									<td><?= $user->id; ?></td>
									<td><?= $user->name; ?></td>
									<td><?= $user->email; ?></td>
									<td>
										<a href="#" id="del" value="<?= $user->id; ?>">Delete</a>
										<a href="#" id="edit" value="<?= $user->id; ?>">Edit</a>
									</td>
								</tr>
							<?php  
							}
							?>
						</tbody> -->
						<tbody id="tbody">
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script>

		<script>
			$(document).on("click", "#add", function(e) {
				e.preventDefault();

				var name = $("#name").val();
				var email = $("#email").val();

				$.ajax({
					url: "<?= base_url() ?>insert",
					type: "POST",
					dataType: "json",
					data: {name: name, email: email},
					success(data) {
						if (data.response == "success") {
							fetch();

							$("#addModal").modal("hide");

							$("#form")[0].reset();

							toastr["success"](data.message);
						}else{
							toastr["error"](data.message);
						}

						toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}
					}
				});
			});

			function fetch() {
				$.ajax({
					url: "<?= base_url() ?>fetch",
					type: "POST",
					dataType: "json",
					success(data) {
						var tbody = "";
						var i = 1;

						for(var key in data) {
							tbody += "<tr>";
							tbody += "<td>"+i+"</td>";
							tbody += "<td>"+data[key]["name"]+"</td>";
							tbody += "<td>"+data[key]["email"]+"</td>";
							tbody += `<td>
													<a href="#" id="del" value="${data[key]['id']}">Delete</a>
													<a href="#" id="edit" value="${data[key]['id']}">Edit</a>
												</td>`;
							tbody += "</tr>";

							i++;
						}

						$("#tbody").html(tbody);
					}
				});
			}
			fetch();

			$(document).on("click", "#del", function(e) {
				e.preventDefault();
				let id = $(this).attr("value");

				if (id != "") {
					const swalWithBootstrapButtons = Swal.mixin({
						customClass: {
							confirmButton: "btn btn-success",
							cancelButton: "btn btn-danger mr-2"
						},
						buttonsStyling: false
					});
					swalWithBootstrapButtons.fire({
						title: "Are you sure?",
						text: "You won't be able to revert this!",
						icon: "warning",
						showCancelButton: true,
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel!",
						reverseButtons: true
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								url: "<?= base_url(); ?>delete",
								type: "POST",
								dataType: "json",
								data: {id: id},
								success(data) {
									fetch();

									swalWithBootstrapButtons.fire({
										title: "Deleted!",
										text: "Your record has been deleted.",
										icon: "success"
									});
								}
							});
						} else if (
							result.dismiss === Swal.DismissReason.cancel
						) {
							swalWithBootstrapButtons.fire({
								title: "Cancelled",
								text: "Your record is safe",
								icon: "error"
							});
						}
					});
				}
			});

			$(document).on("click", "#edit", function(e) {
				e.preventDefault();
				let id = $(this).attr("value");

				if (id != "") {
					$.ajax({
						url: "<?= base_url(); ?>edit",
						type: "POST",
						dataType: "json",
						data: {id: id},
						success(data) {
							if (data.response == 'success') {
								$("#editModel").modal("show");
								$("#edit_id").val(data.user.id);
								$("#edit_name").val(data.user.name);
								$("#edit_email").val(data.user.email);
							}
						}
					});
				}
			});

			$(document).on("click", "#update", function(e) {
				e.preventDefault();

				var id = $("#edit_id").val();
				var name = $("#edit_name").val();
				var email = $("#edit_email").val();
				
				$.ajax({
					url: "<?= base_url(); ?>update",
					type: "POST",
					dataType: "json",
					data: {id:id, name: name, email: email},
					success(data) {
						if (data.response == "success") {
							fetch();
							
							$("#editModel").modal("hide");

							toastr["success"](data.message);
						}else{
							toastr["error"](data.message);
						}
						
						toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}
					}
				});
			});
		</script>
  </body>
</html>