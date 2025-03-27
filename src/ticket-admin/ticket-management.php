<?php	
	include("../config.php");
	include "../session-checker.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ticket Management</title>
	
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
		

	<button type="button" id="pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Launch update/delete modal
	</button>

	<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Ticket
						<?php 
							if (isset($_SESSION["ticket-assigned"])) {
								echo "assigned!";
							}
							else if (isset($_SESSION["ticket-approved"])) {
								echo "approved!";
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
							if (isset($_SESSION["ticket-assigned"])) {
								echo "Ticket #" . $_SESSION['ticket-assigned'] . " was assigned successfully.";
								
							}
							else if (isset($_SESSION["ticket-approved"])) {
								echo "Ticket #" . $_SESSION['ticket-approved'] . " was approved successfully.";
								
							}
							else if (isset($_SESSION["ticket-deleted"])) {
								echo "Ticket #" . $_SESSION['ticket-deleted'] . " was deleted successfully.";
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

	<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Caution!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">Are you sure you want to delete '<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-to-delete-placeholder"></span>' ?</p>
					<p class="fs-4">This action cannot be undone.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary fs-4 px-4" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-danger fs-4 px-5" onclick="delete_ticket()">Yes</a>
				</div>
			</div>
		</div>
	</div>	



	<button type="button" id="delete-error-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#deleteErrorModal">
		Launch delete error modal
	</button>

	<div class="modal" id="deleteErrorModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Error!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">'<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-delete-error-placeholder"></span>' cannot be deleted.</p>
					<p class="fs-4">Close the ticket before deleting.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary fs-4 px-5" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	



	<button type="button" id="approve-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#aprroveModal">
		Launch approve modal
	</button>

	<div class="modal" id="aprroveModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Important!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">Are you sure you want to approve '<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-to-approve-placeholder"></span>' ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary fs-4 px-4" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-primary fs-4 px-5" onclick="approve_ticket()">Yes</a>
				</div>
			</div>
		</div>
	</div>	

	<button type="button" id="approve-error-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#approveErrorModal">
		Launch approve error modal
	</button>

	<div class="modal" id="approveErrorModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Error!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">'<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-approve-error-placeholder"></span>' cannot be approved.</p>
					<p class="fs-4">Ticket must wait for approval before proceeding.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary fs-4 px-5" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	

	<button type="button" id="approve-closed-error-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#approveClosedErrorModal">
		Launch approved closed error modal
	</button>

	<div class="modal" id="approveClosedErrorModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Error!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">'<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-approve-closed-error-placeholder"></span>' cannot be approved.</p>
					<p class="fs-4">Ticket is already closed.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary fs-4 px-5" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	

	<button type="button" id="assign-error-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#assignErrorModal">
		Launch assign error modal
	</button>

	<div class="modal" id="assignErrorModal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Error!</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">'<span class="fw-bold">Ticket #</span><span class="fw-bold" id="ticket-assign-error-placeholder"></span>' cannot be assigned.</p>
					<p class="fs-4">Ticket must be pending or on-going before proceeding.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary fs-4 px-5" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	




    <button type="button" id="details-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#details-modal">
		Launch details modal
	</button>

    <div class="modal modal-lg" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel">
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

                    $date_created_details = explode(" ", $result_details['date_created']);
                    echo "<script>document.getElementById('txt_date_created').value = '" . $date_created_details[0] . "'; </script>";

                    echo "<script>document.getElementById('txt_assigned_to').value = '" . $result_details['assigned_to'] . "'; </script>";

					$date_assigned_details = explode(" ", $result_details['date_assigned']);
                    echo "<script>document.getElementById('txt_date_assigned').value = '" . $date_assigned_details[0] . "'; </script>";

                    echo "<script>document.getElementById('txt_date_completed').value = '" . $result_details['date_completed'] . "'; </script>";
                    echo "<script>document.getElementById('txt_approved_by').value = '" . $result_details['approved_by'] . "'; </script>";

					$date_approved_details = explode(" ", $result_details['date_approved']);
                    echo "<script>document.getElementById('txt_date_approved').value = '" . $date_approved_details[0] . "'; </script>";
                    

                }
            }

            echo "<script>document.getElementById('details-pop-up-trigger').click();</script>";
        }
        
        if (isset($_SESSION["ticket-assigned"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-assigned"]);
		}	
		else if (isset($_SESSION["ticket-approved"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-approved"]);
		}	
		else if (isset($_SESSION["ticket-deleted"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-deleted"]);
		} 

		
	?>
	









	
	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5 mb-4 pb-2">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item fs-4"><a href="ticket-management.php">Tickets</a></li>
							<li class="breadcrumb-item fs-4 active" aria-current="page">All tickets</li>
						</ol>
					</nav>
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
				
				<div class="accout-table-con mx-5 fs-5">
					<div class="account-table-wrapper">
						<?php

							if(!isset($_POST["txtsearch"])) {
								$offset = 0;
								if (isset($_GET['page'])) {
									$offset = (intval($_GET['page']) - 1) * 10;
								}

								$sql = "SELECT * FROM ticket_tbl ORDER BY date_created DESC LIMIT 21 OFFSET " . $offset;

								if($stmt = mysqli_prepare($link, $sql)) {
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}
							else {
 
								$sql = "SELECT * FROM ticket_tbl WHERE ticket_number LIKE ? OR problem LIKE ? OR status LIKE ? ORDER BY date_created DESC LIMIT 15";
                                
								if($stmt = mysqli_prepare($link, $sql)) {
									$text_value = "%" . $_POST["txtsearch"] . "%";
									
									mysqli_stmt_bind_param($stmt, "sss", $text_value, $text_value, $text_value);
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}

							function buildtable($result) {
								if(mysqli_num_rows($result) > 0) {
									echo "<table id='account-table' class='shadow'>";
									
									echo "<thead><tr>";
									echo "
									<th class='fs-4'>Ticket Number</th>
									<th class='fs-4'>Problem</th>
									<th class='fs-4'>Date</th>
									<th class='fs-4'>Time</th>
									<th class='fs-4'>Status</th>
									<th class='fs-4'>Action</th>";
									
									echo "</tr></thead>";
						
									$_SESSION['count'] = 0;
									$_SESSION['excess'] = 0;
									while($row = mysqli_fetch_array($result)) {
										if (intval($_SESSION['count']) < 10) {
											$_SESSION['count'] = intval($_SESSION['count']) + 1;
											echo "<tr class='data-row' >";
											echo "<td id='ticket-number' class='fs-5'>" . $row['ticket_number'] . "</td>";
											echo "<td class='fs-5'>" . $row['problem'] . "</td>";
	
											$date =  explode(' ', $row['date_created']);
											echo "<td class='fs-5'>" . $date[0] . "</td>";

											$time =  date('h:i:s a', strtotime($date[1]));
											echo "<td class='fs-5'>" . $time . "</td>";



											echo "<td id='status' class='fs-5'>" . $row['status'] . "</td>";
											echo "<td>";
											echo "<button title='Details' class='details-modal-btn btn btn-info text-light fs-5' style='width: 3rem'>
													<i class='fa-solid fa-eye'></i>
												</button> ";
											echo "<button title='Assign' id='assign-modal-btn' class='btn bg-blue text-light fs-5'>
													<i class='fa-solid fa-pen'></i>
												</button> ";
											echo "<button title='Approve' id='approve-modal-btn' class='btn btn-success text-light fs-5'>
													<i class='fa-solid fa-thumbs-up'></i>
												</button>";
											echo " <button title='Delete' id='caution-modal-btn' class='btn btn-danger text-light fs-5'>
													<i class='fa-solid fa-trash-can'></i>
												</button>";
											echo "</td>";	
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
										echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='ticket-management.php?page=" . $page - 1 . "'>Previous</a></li>";
									}
									else {
										// else (not in page 1), enable previous button
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark' href='ticket-management.php?page=" . $page - 1 . "'>Previous</a></li>";
									}

									

									if ($page - 2 > 0 && intval($_SESSION['excess']) == 0) {
										// if in last page (no more excess) and there are 2 previous pages, print the left most page
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark' href='ticket-management.php?page=" . $page - 2 . "'>" . $page - 2 . "</a></li>";
									}
									
									if ($page - 1 > 0) {
										// if on page 2 or higher, print previous page
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark' href='ticket-management.php?page=" . $page - 1 . "'>" . $page - 1 . "</a></li>";
									}

									// print the active page
									echo "<li class='page-item active fs-4 text-dark'><a class='page-link fs-4 px-3 text-light' href='ticket-management.php?page=" . $page . "'>" . $page . "</a></li>";

									if (intval($_SESSION['excess']) > 0) {
										// if there is next page (has excess), print the next page
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark' href='ticket-management.php?page=" . $page + 1 . "'>" . $page + 1 . "</a></li>";
									}
									

									if ($page - 1 <= 0 && intval($_SESSION['excess']) > 10) {
										// if in first page and there is 2 next pages, print the right most page
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark' href='ticket-management.php?page=" . $page + 2 . "'>" . $page + 2 . "</a></li>";
									}

									if (intval($_SESSION['excess']) == 0) {
										// if in last page (no more excess), disable next button
										echo "<li class='page-item'><a class='page-link fs-4 px-3 text-dark disabled' href='ticket-management.php?page=" . $page + 1 . "'>Next</a></li>";
									}
									else {
										// else, enable next button
										echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='ticket-management.php?page=" . $page + 1 . "'>Next</a></li>";
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
    const details_triggers = document.getElementsByClassName("details-modal-btn");

    for (let btn of details_triggers) {
		btn.addEventListener('click', () => {
            window.location.href = "ticket-management.php?ticket_details=" + btn.parentNode.parentNode.childNodes[0].innerHTML;
		});
	}

	const data_row = Array.from(document.getElementsByClassName("data-row"));

	data_row.forEach(element => {

		// delete modal oparations
		element.querySelector('#caution-modal-btn').addEventListener('click', () => {
			if (element.querySelector('#status').innerHTML == "CLOSED") {
				document.getElementById('ticket-to-delete-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('caution-pop-up-trigger').click();
			}
			else {
				document.getElementById('ticket-delete-error-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('delete-error-pop-up-trigger').click();
			}
		});

		// approve modal oparations
		element.querySelector('#approve-modal-btn').addEventListener('click', () => {
			if (element.querySelector('#status').innerHTML == "CLOSED") {
				document.getElementById('ticket-approve-closed-error-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('approve-closed-error-pop-up-trigger').click();
			}

			else if (element.querySelector('#status').innerHTML == "FOR APPROVAL") {
				document.getElementById('ticket-to-approve-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('approve-pop-up-trigger').click();
			}
			else {
				document.getElementById('ticket-approve-error-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('approve-error-pop-up-trigger').click();
			}
		});

		// assign  modal oparations
		element.querySelector('#assign-modal-btn').addEventListener('click', () => {
			if (element.querySelector('#status').innerHTML == "PENDING" || element.querySelector('#status').innerHTML == "ON-GOING") {
				window.location.href = "assign-ticket.php?ticket_number=" + element.querySelector('#ticket-number').innerHTML;
			}
			else {
				document.getElementById('ticket-assign-error-placeholder').innerHTML = element.querySelector('#ticket-number').innerHTML;
				document.getElementById('assign-error-pop-up-trigger').click();
			}
		});

	});


	function delete_ticket() {
		window.location.href = "delete-ticket.php?ticket_number=" + document.getElementById('ticket-to-delete-placeholder').innerHTML;
	}


	function approve_ticket() {
		window.location.href = "approve-ticket.php?ticket_number=" + document.getElementById('ticket-to-approve-placeholder').innerHTML;
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
