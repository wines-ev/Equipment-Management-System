<?php	
	include("../config.php");
	include "../session-checker.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Equipment Management</title>
	
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
		

	<button type="button" id="pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Launch update/delete modal
	</button>

	<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Equipment
						<?php 
							if (isset($_SESSION["equipment-added"])) {
								echo "added!";
							}
							else if (isset($_SESSION["equipment-updated"])) {
								echo "updated!";
							}
							else if (isset($_SESSION["equipment-deleted"])) {
								echo "deleted!";
							}
						?>
					</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">
						<?php 
							if (isset($_SESSION["equipment-added"])) {
								echo "Asset #" . $_SESSION['equipment-added'] . " was added successfully.";
								
							}
							else if (isset($_SESSION["equipment-updated"])) {
								echo "Asset #" . $_SESSION['equipment-updated'] . " was updated successfully.";
								
							}
							else if (isset($_SESSION["equipment-deleted"])) {
								echo "Asset #" . $_SESSION['equipment-deleted'] . " was deleted successfully.";
							}

							
						?>
					
					</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary fs-4 px-4" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	
	
	<button type="button" id="caution-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
		Launch caution modal
	</button>

	<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Caution!</p>
					<a href="equipment-management.php" type="button" class="btn-close fs-4" aria-label="Close"></a>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">Are you sure you want to delete '<span class="fw-bold">Asset #</span><span class="fw-bold" id="asset-to-delete-placeholder"></span>' ?</p>
					<p class="fs-4">This action cannot be undone.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary fs-4" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-danger fs-4" onclick="delete_user()">Yes</a>
				</div>
			</div>
		</div>
	</div>	

	<?php

		if (isset($_SESSION["equipment-added"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["equipment-added"]);
		}	
		else if (isset($_SESSION["equipment-updated"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["equipment-updated"]);
		}	
		else if (isset($_SESSION["equipment-deleted"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["equipment-deleted"]);
		}	
		
	?>
	













	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5 mb-4 pb-2">
					<p class="fs-4 mb-0">Equipments / All equipments</p>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" class="d-flex gap-3">
						<div class="input-group flex-fill" style="width: 30rem;">
							<input type="text" class="form-control fs-4" name="txtsearch" placeholder="Search something">
							<button class="btn bg-secondary text-light btn-outline-secondary fs-4 px-2" type="submit" name="btnsearch">
								<i class="fa-solid fa-magnifying-glass px-3"></i>
							</button>
						</div>
						<a class="btn text-light bg-blue fs-4 py-2 px-4" href = "add-equipment.php">Add equipment</a>
					</form>
				</div>
				
				<div class="accout-table-con mx-5 fs-5">
					<div class="account-table-wrapper">
						<?php

							if(!isset($_POST["txtsearch"])) {
								$offset = 0;
								if (isset($_GET['page'])) {
									$offset = (intval($_GET['page']) - 1) * 10;
								}
								$sql = "SELECT * FROM equipment_tbl ORDER BY date_created DESC LIMIT 21 OFFSET " . $offset;

								if($stmt = mysqli_prepare($link, $sql)) {
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}
							else {
                                // Asset Number, Serial Number, Type, and Department.  
								$sql = "SELECT * FROM equipment_tbl WHERE asset_number LIKE ? OR serial_number LIKE ? OR type LIKE ? OR department LIKE ? ORDER BY date_created DESC LIMIT 10";

								if($stmt = mysqli_prepare($link, $sql)) {
									$text_value = "%" . $_POST["txtsearch"] . "%";
									
									
									mysqli_stmt_bind_param($stmt, "ssss", $text_value, $text_value, $text_value, $text_value);
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}

							function buildtable($result) {
								if(mysqli_num_rows($result) > 0) {
									echo "<table class='shadow' id='account-table'>";
									
									echo "<thead><tr>";
									echo "
									<th class='fs-4'>Asset Number</th>
									<th class='fs-4'>Serial Number</th>
									<th class='fs-4'>Type</th>
									<th class='fs-4'>Branch</th>
									<th class='fs-4'>Status</th>
									<th class='fs-4'>Created by</th>";
									if ($_SESSION["user_type"] != "USER") {
										echo "<th class='fs-4'>Action</th>";
									}
									
									
									echo "</tr></thead>";
						
									$_SESSION['count'] = 0;
									$_SESSION['excess'] = 0;
									while($row = mysqli_fetch_array($result)) {
										if (intval($_SESSION['count']) < 10) {
											$_SESSION['count'] = intval($_SESSION['count'] + 1);
											echo "<tr class='data-row' >";
											echo "<td id='asset-number' class='fs-5'>" . $row['asset_number'] . "</td>";
											echo "<td class='fs-5'>" . $row['serial_number'] . "</td>";
											echo "<td class='fs-5'>" . $row['type'] . "</td>";
											echo "<td class='fs-5'>" . $row['branch'] . "</td>";
											echo "<td class='fs-5'>" . $row['status'] . "</td>";
											
											if ($_SESSION["user_type"] != "USER") {
												echo "<td class='fs-5'>" . $row['created_by'] . "</td>";
												echo "<td>";
												echo "<a href='update-equipment.php?asset_number=" . urlencode($row['asset_number']) . "' class='btn bg-blue text-light fs-5 me-2'><i class='fa-solid fa-pen-to-square'></i></a> ";
												echo "
													<button id='caution-modal-btn' class='btn btn-danger text-light fs-5'>
														<i class='fa-solid fa-trash-can'></i>
													</button>";
												echo "</td>";	
											}
											else {
												echo "<td class='fs-5' style='padding: 14.5px 0'>" . $row['created_by'] . "</td>";
											}
											echo "</tr>";
										}
										else {
											$_SESSION['excess'] = intval($_SESSION['excess']) + 1;
										}
										
									}
									echo "</table>";
								}
								else {
									echo "<p class='fs-4'>No rercord/s found.</p>";
								}
							}
						?>
					</div>

					<nav aria-label="Page navigation example">
						
						<div class="mt-4 d-flex justify-content-between align-items-center">
							<?php
								$page = 1;
								if (isset($_GET['page'])) {
									$page = intval($_GET['page']);
								}
							?>
							<p class="fs-4">Showing entries <?php echo (($page - 1) * 10) + 1 . " - " . intval($_SESSION['count']) + (($page - 1) * 10); ?></p>
							<ul class="pagination">
								
								
								<?php
									$page = 1;
							
									if (isset($_GET['page'])) {
										$page = intval($_GET['page']);
									}
									
									if ($page == 1) {
										// if in page 1, disable previous button
										echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='equipment-management.php?page=" . $page - 1 . "'>Previous</a></li>";
									}
									else {
										// else (not in page 1), enable previous button
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page - 1 . "'>Previous</a></li>";
									}

									

									if ($page - 2 > 0 && intval($_SESSION['excess']) == 0) {
										// if in last page (no more excess) and there are 2 previous pages, print the left most page
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page - 2 . "'>" . $page - 2 . "</a></li>";
									}
									
									if ($page - 1 > 0) {
										// if on page 2 or higher, print previous page
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page - 1 . "'>" . $page - 1 . "</a></li>";
									}

									// print the active page
									echo "<li class='page-item active fs-4 text-dark'><a class='page-link fs-4 text-light' href='equipment-management.php?page=" . $page . "'>" . $page . "</a></li>";

									if (intval($_SESSION['excess']) > 0) {
										// if there is next page (has excess), print the next page
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page + 1 . "'>" . $page + 1 . "</a></li>";
									}
									

									if ($page - 1 <= 0 && intval($_SESSION['excess']) > 10) {

										// if in first page and there is 2 next pages, print the right most page
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page + 2 . "'>" . $page + 2 . "</a></li>";
									}

									if (intval($_SESSION['excess']) == 0) {
										// if in last page (no more excess), disable next button
										echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='equipment-management.php?page=" . $page + 1 . "'>Next</a></li>";
									}
									else {
										// else, enable next button
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='equipment-management.php?page=" . $page + 1 . "'>Next</a></li>";
									}
									

								?>
								
						</ul>
						</div>
					</nav>
				</div>
				
			</div>
		</div>		
	</div>
	
</body>

<script src="../../js/script.js"></script>


<script>


	const data_row = Array.from(document.getElementsByClassName("data-row"));

	data_row.forEach(element => {
		if (element.querySelector('#caution-modal-btn')) {
			element.querySelector('#caution-modal-btn').addEventListener('click', () => {
				document.getElementById('asset-to-delete-placeholder').innerHTML = element.querySelector('#asset-number').innerHTML;
				document.getElementById('caution-pop-up-trigger').click();
			});
		}
	});

	function delete_user() {
		window.location.href = "delete-equipment.php?asset_number=" + document.getElementById('asset-to-delete-placeholder').innerHTML;
	}

	const rows = document.getElementById("account-table").childNodes[1].childNodes;

	
	for (var i = 0; i < rows.length; i++) {


		if (i%2 == 0) {
			rows[i].classList.add("bg-blue-50");
		}
	}
	
</script>
</html>
