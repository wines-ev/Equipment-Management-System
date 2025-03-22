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
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body>
		

	<button type="button" id="pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Launch update/delete modal
	</button>

	<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Ticket
						<?php 
							if (isset($_SESSION["ticket-added"])) {
								echo "added!";
							}
							else if (isset($_SESSION["ticket-updated"])) {
								echo "updated!";
							}
							else if (isset($_SESSION["ticket-deleted"])) {
								echo "deleted!";
							}
						?>
					</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">
						<?php 
							if (isset($_SESSION["ticket-added"])) {
								echo "Asset #" . $_SESSION['ticket-added'] . " was added successfully.";
								
							}
							else if (isset($_SESSION["ticket-updated"])) {
								echo "Asset #" . $_SESSION['ticket-updated'] . " was updated successfully.";
								
							}
							else if (isset($_SESSION["ticket-deleted"])) {
								echo "Asset #" . $_SESSION['ticket-deleted'] . " was deleted successfully.";
							}

							
						?>
					
					</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary fs-4 px-5" data-bs-dismiss="modal">OK</button>
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
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">Are you sure you want to delete '<span class="fw-bold">Ticket #</span><span class="fw-bold" id="asset-to-delete-placeholder"></span>' ?</p>
					<p class="fs-4">This action cannot be undone.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary fs-4 px-4" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-danger fs-4 px-5" onclick="delete_user()">Yes</a>
				</div>
			</div>
		</div>
	</div>	




    <button type="button" id="details-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#details-modal">
		Launch details modal
	</button>

    <div class="modal modal-lg" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content" onmouse>
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Ticket #<span id="details_ticket_num"></span> </p>
					<a href="ticket-management.php" type="button" class="btn-close fs-4" aria-label="Close"></a>
				</div>
				<div class="modal-body fs-4 px-3">

					<div class="d-flex gap-3">
						<div class="flex-fill">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Problem</span>
								<input class="form-control fs-4" id="txt_problem" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Details</span>
								<input class="form-control fs-4" id="txt_details" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Status</span>
								<input class="form-control fs-4" id="txt_status" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Created By</span>
								<input class="form-control fs-4" id="txt_created_by" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Created</span>
								<input class="form-control fs-4" id="txt_date_created" disabled> </input>
							</div>
						</div>

						<div class="flex-fill">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Assigned To</span>
								<input class="form-control fs-4" id="txt_assigned_to" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Assigned</span>
								<input class="form-control fs-4" id="txt_date_assigned" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Completed</span>
								<input class="form-control fs-4" id="txt_date_completed" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Approved By</span>
								<input class="form-control fs-4" id="txt_approved_by" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Approved</span>
								<input class="form-control fs-4" id="txt_date_approved" disabled> </input>
							</div>

						</div>
					</div>
                    
				</div>
				<div class="modal-footer">
					<a href="ticket-management.php" class="btn btn-primary fs-4 px-5">OK</a>
				</div>
			</div>
		</div>
	</div>	


    
	<?php
        if (isset($_GET["ticket_details"])) {
            $sql = "SELECT * FROM ticket_tbl WHERE ticket_number = ?";

            if($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $_GET["ticket_details"]);
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    $result_details = mysqli_fetch_array($result);
                    echo "<script>document.getElementById('details_ticket_num').innerHTML = '" . $result_details['ticket_number'] . "'; </script>";
                    echo "<script>document.getElementById('txt_problem').value = '" . $result_details['problem'] . "'; </script>";
                    echo "<script>document.getElementById('txt_details').value = '" . $result_details['details'] . "'; </script>";
                    echo "<script>document.getElementById('txt_status').value = '" . $result_details['status'] . "'; </script>";
                    echo "<script>document.getElementById('txt_created_by').value = '" . $result_details['created_by'] . "'; </script>";

                    $date_created_details = explode(" ",$result_details['date_created']);

                    echo "<script>document.getElementById('txt_date_created').value = '" . $date_created_details[0] . "'; </script>";
                    echo "<script>document.getElementById('txt_assigned_to').value = '" . $result_details['assigned_to'] . "'; </script>";
                    echo "<script>document.getElementById('txt_date_assigned').value = '" . $result_details['date_assigned'] . "'; </script>";
                    echo "<script>document.getElementById('txt_date_completed').value = '" . $result_details['date_completed'] . "'; </script>";
                    echo "<script>document.getElementById('txt_approved_by').value = '" . $result_details['approved_by'] . "'; </script>";
                    echo "<script>document.getElementById('txt_date_approved').value = '" . $result_details['date_approved'] . "'; </script>";
                    

                }
            }

            echo "<script>document.getElementById('details-pop-up-trigger').click();</script>";
        }
        
        if (isset($_SESSION["ticket-added"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-added"]);
		}	
		else if (isset($_SESSION["ticket-updated"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-updated"]);
		}	
		else if (isset($_SESSION["ticket-deleted"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-deleted"]);
		} 

		
	?>
	













	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/user_sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5 mb-4 pb-2">
					<p class="fs-4 mb-0">Tickets / All tickets</p>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" class="d-flex gap-3">
						<div class="input-group flex-fill" style="width: 30rem;">
							<input type="text" class="form-control fs-4" name="txtsearch" placeholder="Search something">
							<button class="btn bg-secondary text-light btn-outline-secondary fs-4 px-2" type="submit" name="btnsearch">
								<i class="fa-solid fa-magnifying-glass px-3"></i>
							</button>
						</div>
						<a class="btn text-light bg-blue fs-4 py-2 px-4" href = "create-ticket.php">Create ticket</a>
					</form>
				</div>
				
				<div class="accout-table-con mx-5 fs-5 shadow-lg">
					<div class="account-table-wrapper">
						<?php

							if(!isset($_POST["txtsearch"])) {
								$sql = "SELECT * FROM ticket_tbl WHERE created_by = ? ORDER BY date_created DESC";

								if($stmt = mysqli_prepare($link, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}
							else {
                                // Asset Number, Serial Number, Type, and Department.  
								$sql = "SELECT * FROM ticket_tbl WHERE ticket_number LIKE ? OR problem LIKE ? OR status LIKE ? AND created_by = ? ORDER BY date_created DESC";
                                
								if($stmt = mysqli_prepare($link, $sql)) {
									$text_value = "%" . $_POST["txtsearch"] . "%";
									
									
									mysqli_stmt_bind_param($stmt, "ssss", $text_value, $text_value, $text_value, $_SESSION["username"]);
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}

							function buildtable($result) {
								if(mysqli_num_rows($result) > 0) {
									echo "<table id='account-table'>";
									
									echo "<thead><tr>";
									echo "
									<th class='fs-4'>Ticket Number</th>
									<th class='fs-4'>Problem</th>
									<th class='fs-4'>Date</th>
									<th class='fs-4'>Status</th>
									<th class='fs-4'>Action</th>";
									
									echo "</tr></thead>";
						

								while($row = mysqli_fetch_array($result)) {
									echo "<tr id='data-row' >";
									echo "<td class='fs-5'>" . $row['ticket_number'] . "</td>";
									echo "<td class='fs-5'>" . $row['problem'] . "</td>";

                                    $date =  explode(' ', $row['date_created']);

									echo "<td class='fs-5'>" . $date[0] . "</td>";
									echo "<td class='fs-5'>" . $row['status'] . "</td>";
									echo "<td>";
                                    echo "<button title='Details' class='details-modal-btn btn btn-success text-light fs-5 me-3'>
											<i class='fa-solid fa-eye'></i>
										</button>";
									echo "<a title='Edit' href='update-ticket.php?ticket_number=" . urlencode($row['ticket_number']) . "' class='btn bg-blue text-light fs-5 me-2'>
                                            <i class='fa-solid fa-pen-to-square'></i>
                                        </a> ";
									echo " <button title='Delete' class='caution-modal-btn btn btn-danger text-light fs-5'>
											<i class='fa-solid fa-trash-can'></i>
										</button>";
									echo "</td>";	
									echo "</tr>";
								}
									echo "</table>";
								}
								else {
									echo "<p class='fs-4'>No rercord/s found.</p>";
								}
							}
						?>
					</div>
				</div>

				
			</div>
		</div>		
	</div>
	
</body>

<script>









	const open_nav_icon = document.getElementById("open-nav-icon");
	const close_nav_icon = document.getElementById("close-nav-icon");
	const sidenav_title = document.getElementById("sidenav_title");
	const navtab_texts = document.getElementsByClassName("navtab-text");

	function openNav() {
		document.getElementById("sidenav").style.width = "20rem";
		open_nav_icon.style.display = "none";
		close_nav_icon.style.display = "block";
		sidenav_title.style.display = "block";		

		document.getElementById("sidenav").style.padding = "0 2rem";

		document.getElementById("sidenav").classList.remove("align-items-center");

		document.getElementById("sidenav-header").classList.remove("justify-content-center");
		document.getElementById("sidenav-header").classList.add("justify-content-between");
		
		for(let text of navtab_texts) {
			text.style.display = "block";
		}
	}

	function closeNav() {
		if (screen.width > 767) {
			document.getElementById("sidenav").style.width = "7rem";
		}
		else {
			document.getElementById("sidenav").style.width = "0";
			document.getElementById("sidenav").style.padding = "0";
		}

		document.getElementById("sidenav").classList.add("align-items-center");

		document.getElementById("sidenav-header").classList.remove("justify-content-between");
		document.getElementById("sidenav-header").classList.add("justify-content-center");

		
		open_nav_icon.style.display = "block";
		close_nav_icon.style.display = "none";
		sidenav_title.style.display = "none";

		for(let text of navtab_texts) {
			text.style.display = "none";
		}
	}

    const details_triggers = document.getElementsByClassName("details-modal-btn");

    for (let btn of details_triggers) {
		btn.addEventListener('click', () => {

            window.location.href = "ticket-management.php?ticket_details=" + btn.parentNode.parentNode.childNodes[0].innerHTML;

            
		});
	}

	const caution_triggers = document.getElementsByClassName("caution-modal-btn");
	
	for (let btn of caution_triggers) {
		btn.addEventListener('click', () => {
			document.getElementById('asset-to-delete-placeholder').innerHTML = btn.parentNode.parentNode.childNodes[0].innerHTML
			document.getElementById('caution-pop-up-trigger').click();
		});
	}

	function delete_user() {
		window.location.href = "delete-ticket.php?ticket_number=" + document.getElementById('asset-to-delete-placeholder').innerHTML;
	}

	const rows = document.getElementById("account-table").childNodes[1].childNodes;

	
	for (var i = 0; i < rows.length; i++) {


		if (i%2 == 0) {
			rows[i].classList.add("bg-blue-50");
		}
	}

	const details_modal = document.getElementById("details-modal").addEventListener('click', (e) => {
		if (Array.from(e.target.classList).includes("modal")) {
			window.location.href = "ticket-management.php";
		}
		
	})
	
</script>
</html>
