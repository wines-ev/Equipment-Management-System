<?php	
	include("../config.php");
	include "../session-checker.php";

	$_SESSION["priviledges"] = [
		"can_create" => false,
		"can_view" => false,
		"can_edit" => false,
		"can_delete" => false,
		"can_complete" => false,
		"can_assign" => false,
		"can_approve" => false,
	];


	if ($_SESSION['user_type'] == "ADMINISTRATOR") {
		$_SESSION["priviledges"]["can_view"] = true;
		$_SESSION["priviledges"]["can_assign"] = true;
		$_SESSION["priviledges"]["can_approve"] = true;
		$_SESSION["priviledges"]["can_delete"] = true;
	}
	else if ($_SESSION['user_type'] == "TECHNICAL") {
		$_SESSION["priviledges"]["can_view"] = true;
		$_SESSION["priviledges"]["can_complete"] = true;
	}
	else if ($_SESSION['user_type'] == "USER") {
		$_SESSION["priviledges"]["can_create"] = true;
		$_SESSION["priviledges"]["can_view"] = true;
		$_SESSION["priviledges"]["can_edit"] = true;
		$_SESSION["priviledges"]["can_delete"] = true;
	}
	else {
		header("Location: ../logout.php");
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ticket Management</title>
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
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
				<div class="modal-header align-items-center">
					<span class="mb-0 fs-1 me-3" id="modal-icon"></span>
					<p class="modal-title fs-1" id="modal-title"></p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4 mb-0" id="modal-message"> </p>
					<p class="d-none" id="ticket-placeholder"></p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary fs-4 px-5" id="btn-ok" data-bs-dismiss="modal">OK</button>
					<button type="button" class="btn btn-secondary fs-4 px-4" id="btn-cancel" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-primary fs-4 px-5" id="btn-complete" onclick="complete_ticket()">Yes</a>
					<button class="btn btn-danger fs-4 px-5" id="btn-delete" onclick="delete_ticket()">Yes</a>
					<button class="btn btn-primary fs-4 px-5" id="btn-approve" onclick="approve_ticket()">Yes</a>
				</div>
			</div>
		</div>
	</div>	



    <button type="button" id="details-pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4 d-none" data-bs-toggle="modal" data-bs-target="#details-modal">
		Launch details modal
	</button>

    <div class="modal modal-lg" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<?php
					if (isset($_GET["ticket_details"])) {

						$sql = "SELECT * FROM ticket_tbl WHERE ticket_number = ?";
						if($stmt = mysqli_prepare($link, $sql)) {
							mysqli_stmt_bind_param($stmt, "s", $_GET["ticket_details"]);
							if (mysqli_stmt_execute($stmt)) {
								$result = mysqli_stmt_get_result($stmt);
								$result_details = mysqli_fetch_array($result);

								$details = str_replace(array("\r", "\n"), ' ', $result_details['details']);

								$date_created = explode(' ', $result_details['date_created'])[0];
								$date_assigned = explode(' ', $result_details['date_assigned'])[0];
								$date_completed = explode(' ', $result_details['date_completed'])[0];
								$date_approved = explode(' ', $result_details['date_approved'])[0];
							}
						}
					}

				?>
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">Ticket #<?php echo $result_details['ticket_number'] ?></p>
					<a href="ticket-management.php" type="button" class="btn-close fs-4" aria-label="Close"></a>
				</div>
				<div class="modal-body fs-4 px-3"> 
					<div class="d-flex gap-3">
						<div class="flex-fill">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Problem</span>
								<input class="form-control fs-4" value="<?php echo $result_details['problem'] ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Details</span>
								<input class="form-control fs-4" value="<?php echo $details ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Status</span>
								<input class="form-control fs-4" value="<?php echo $result_details['status'] ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Created By</span>
								<input class="form-control fs-4" value="<?php echo $result_details['created_by'] ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Created</span>
								<input class="form-control fs-4" value="<?php echo $date_created ?>" disabled> </input>
							</div>
						</div>

						<div class="flex-fill">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Assigned To</span>
								<input class="form-control fs-4" value="<?php echo $result_details['assigned_to'] ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Assigned</span>
								<input class="form-control fs-4" value="<?php echo $date_assigned ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Completed</span>
								<input class="form-control fs-4" value="<?php echo $date_completed ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Approved By</span>
								<input class="form-control fs-4" value="<?php echo $result_details['approved_by'] ?>" disabled> </input>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Date Approved</span>
								<input class="form-control fs-4" value="<?php echo $date_approved ?>" disabled> </input>
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
            echo "<script>document.getElementById('details-pop-up-trigger').click();</script>";
        }
	?>
		
	<script>
		let modal_obj = {
			'icon' : "",
			'header' : "",
			'message' : "",
			'ticket_number' : "",
			'buttons' : [],
		}

		function show_modal(type, ticket_number) {
			switch (type) {
				case "added":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Added!";
					modal_obj.message = "Ticket #" + ticket_number + " was added successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "updated":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Updated!";
					modal_obj.message = "Ticket #" + ticket_number + " was updated successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "update_error":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Update Error!";
					modal_obj.message = "Ticket #" + ticket_number + "  cannot be updated. <br> Ticket must	be pending before proceeding.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "deleted":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Deleted!";
					modal_obj.message = "Ticket #" + ticket_number + " was deleted successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "assigned":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Assigned!";
					modal_obj.message = "Ticket #" + ticket_number + " was assigned successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "completed":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Completed!";
					modal_obj.message = "Ticket #" + ticket_number + " was completed successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "approved":
					modal_obj.icon = '<i class="fa-solid fa-circle-check text-success"></i>';
					modal_obj.header = "Ticket Approved!";
					modal_obj.message = "Ticket #" + ticket_number + " was approved successfuly.";
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "assign_error":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Assignment Error!";
					modal_obj.message = 'Ticket #' +  ticket_number + ' cannot be assigned.<br> Ticket must be pending or on-going before proceeding.';
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "complete_caution":
					modal_obj.icon = '<i class="fa-solid fa-circle-info text-primary"></i>';
					modal_obj.header = "Important!";
					modal_obj.message = 'Are you sure you want to complete Ticket #' + ticket_number + '?';
					modal_obj.buttons = ['none', 'block', 'block', 'none', 'none'];
				break;

				case "complete_error":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Completion Error!";
					modal_obj.message = 'Ticket #' +  ticket_number + ' cannot be completed. <br>Ticket must be on-going before proceeding.';
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "approve_caution":
					modal_obj.icon = '<i class="fa-solid fa-circle-info text-primary"></i>';
					modal_obj.header = "Important!";
					modal_obj.message = 'Are you sure you want to approve Ticket #' +  ticket_number + '?.';
					modal_obj.buttons = ['none', 'block', 'none', 'none', 'block'];
				break;

				case "approve_error_closed":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Approval Error!";
					modal_obj.message = 'Ticket #' +  ticket_number + '? cannot be approved.<br> Ticket is already closed.';
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;

				case "approve_error":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Approval Error!";
					modal_obj.message = 'Ticket #' +  ticket_number + '? cannot be approved.<br> Ticket is must be waiting for approval before proceeding.';
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;
				
				case "delete_caution":
					modal_obj.icon = '<i class="fa-solid fa-circle-info text-primary"></i>';
					modal_obj.header = "Caution!";
					modal_obj.message = 'Are you sure you want to delete Ticket #' +  ticket_number + '? <br> This action cannot be undone.';
					modal_obj.buttons = ['none', 'block', 'none', 'block', 'none'];
				break;

				case "delete_error":
					modal_obj.icon = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
					modal_obj.header = "Deletion Error!";
					modal_obj.message = 'Ticket #' +  ticket_number + ' cannot be deleted. <br>Ticket must be closed before proceeding.';
					modal_obj.buttons = ['block', 'none', 'none', 'none', 'none'];
				break;
			}
			document.getElementById('modal-icon').innerHTML = modal_obj.icon;
			document.getElementById('modal-title').innerHTML = modal_obj.header;
			document.getElementById('modal-message').innerHTML = modal_obj.message;
			document.getElementById('ticket-placeholder').innerHTML = ticket_number;
			document.getElementById('btn-ok').style.display = modal_obj.buttons[0];
			document.getElementById('btn-cancel').style.display = modal_obj.buttons[1];
			document.getElementById('btn-complete').style.display = modal_obj.buttons[2];
			document.getElementById('btn-delete').style.display = modal_obj.buttons[3];
			document.getElementById('btn-approve').style.display = modal_obj.buttons[4];
			document.getElementById('pop-up-trigger').click();

		}
	</script>

    <?php
        if (isset($_SESSION["ticket-added"])) {
			echo "<script>show_modal('added', " . $_SESSION["ticket-added"] .")</script>";
			unset($_SESSION["ticket-added"]);
		}	
		else if (isset($_SESSION["ticket-updated"])) {
			echo "<script>show_modal('updated', " . $_SESSION["ticket-updated"] .")</script>";
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["ticket-updated"]);
		}	
		else if (isset($_SESSION["ticket-deleted"])) {
			echo "<script>show_modal('deleted', " . $_SESSION["ticket-deleted"] .")</script>";
			unset($_SESSION["ticket-deleted"]);
		} 	

		else if (isset($_SESSION["ticket-assigned"])) {
			echo "<script>show_modal('assigned', " . $_SESSION["ticket-assigned"] .")</script>";
			unset($_SESSION["ticket-assigned"]);
		} 

		else if (isset($_SESSION["ticket-completed"])) {
			echo "<script>show_modal('completed', " . $_SESSION["ticket-completed"] .")</script>";
			unset($_SESSION["ticket-completed"]);
		} 

		else if (isset($_SESSION["ticket-approved"])) {
			echo "<script>show_modal('approved', " . $_SESSION["ticket-approved"] .")</script>";
			unset($_SESSION["ticket-approved"]);
		} 
		
	?>
	

	




	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5 mb-4 pb-2">
					<p class="fs-4 mb-0">Tickets / All tickets</p>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" class="d-flex gap-3">
						<div class="input-group flex-fill" style="width: 35rem;">
							<div class="dropdown me-2">
								<button class="btn bg-white border dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									Sort by &nbsp;&nbsp;&nbsp;
								</button>
								<ul class="dropdown-menu">
									<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?order=ticket_number" class="dropdown-item fs-4">Ticket number</a></li>
									<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?order=problem" class="dropdown-item fs-4">Problem</a></li>
									<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?order=date_created" class="dropdown-item fs-4">Date</a></li>
									<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?order=status" class="dropdown-item fs-4">Status</a></li>
								</ul>
							</div>

							
							<input type="text" class="form-control fs-4" name="txtsearch" placeholder="Search something">
							<button class="btn bg-secondary text-light btn-outline-secondary fs-4 px-2" type="submit" name="btnsearch">
								<i class="fa-solid fa-magnifying-glass px-3"></i>
							</button>
						</div>
						<?php echo $_SESSION["priviledges"]["can_create"] ? "<a class='btn text-light bg-blue fs-4 py-2 px-4' href = 'create-ticket.php'>Create tickets</a>" : "" ?>
					</form>
				</div>
				
				<div class="accout-table-con mx-5 fs-5">
					<div class="account-table-wrapper">
						<?php
							$offset = isset($_GET['page']) ? (intval($_GET['page']) - 1) * 10 : 0;
							$sql = "";
							$param = "";
							$order = isset($_GET["order"]) ? $_GET["order"] : "date_created";

							if(!isset($_POST["txtsearch"])) {

								if ($_SESSION["user_type"] == "ADMINISTRATOR") {
									$sql = "SELECT * FROM ticket_tbl ORDER BY " . $order . " DESC LIMIT 21 OFFSET " . $offset;
								}
								else if ($_SESSION["user_type"] == "TECHNICAL") {
									$sql = "SELECT * FROM ticket_tbl WHERE assigned_to = ? ORDER BY " . $order . " DESC LIMIT 21 OFFSET " . $offset;
									$param = $_SESSION["username"];
								}
								else {
									$sql = "SELECT * FROM ticket_tbl WHERE created_by = ? ORDER BY " . $order . " DESC LIMIT 21 OFFSET " . $offset;
									$param = $_SESSION["username"];
								}

								
								if($stmt = mysqli_prepare($link, $sql)) {
                                    if (!empty($param)) {
										mysqli_stmt_bind_param($stmt, "s", $param);
									}
									if (mysqli_stmt_execute($stmt)) {
										$result = mysqli_stmt_get_result($stmt);
										buildtable($result);
									}
								}
							}
							else {

								if ($_SESSION["user_type"] == "ADMINISTRATOR") {
									$sql = "SELECT * FROM ticket_tbl WHERE (ticket_number LIKE ? OR problem LIKE ? OR status LIKE ?) ORDER BY " . $order . " DESC LIMIT 21";
								}
								else if ($_SESSION["user_type"] == "TECHNICAL") {
									$sql = "SELECT * FROM ticket_tbl WHERE (ticket_number LIKE ? OR problem LIKE ? OR status LIKE ?) AND assigned_to = ? ORDER BY " . $order . " DESC LIMIT 21";
									$param = $_SESSION["username"];
								}
								else {
									$sql = "SELECT * FROM ticket_tbl WHERE (ticket_number LIKE ? OR problem LIKE ? OR status LIKE ?) AND created_by = ? ORDER BY " . $order . " DESC LIMIT 21";
									$param = $_SESSION["username"];
								}
								
                                
								if($stmt = mysqli_prepare($link, $sql)) {
									$text_value = "%" . $_POST["txtsearch"] . "%";
									
									if(!empty($param)) {
										mysqli_stmt_bind_param($stmt, "ssss", $text_value, $text_value, $text_value, $_SESSION["username"]);
									}
									else {
										mysqli_stmt_bind_param($stmt, "sss", $text_value, $text_value, $text_value);
									}
									
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
										<th class='fs-4'>Date</th>";

									if ($_SESSION["user_type"] == "ADMINISTRATOR" || $_SESSION["user_type"] == "TECHNICAL") {
										echo "<th class='fs-4'>Time</th>";
									}
									
									echo "
										<th class='fs-4'>Status</th>
										<th class='fs-4'>Action</th>
									";
									
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

											if ($_SESSION["user_type"] == "ADMINISTRATOR" || $_SESSION["user_type"] == "TECHNICAL") {
                                                $time=  date('h:i:s a', strtotime($date[1]));
                                                echo "<td class='fs-5'>" . $time . "</td>";
											}

											echo "<td id='status' class='fs-5'>" . $row['status'] . "</td>";
											echo "<td class='d-flex justify-content-center gap-2'>";

											if ($_SESSION["priviledges"]["can_view"]) {
												echo "<button title='Details' id='details-modal-btn' class='btn btn-info text-light fs-5'>
													<i class='fa-solid fa-eye'></i>
												</button>";
											}
											
											if ($_SESSION["priviledges"]["can_edit"]) {
												echo "<button title='Update' id='update-modal-btn' class='btn bg-blue text-light fs-5'>
													<i class='fa-solid fa-pen-to-square'></i>
												</button> ";
											}

											if ($_SESSION["priviledges"]["can_complete"]) {
												echo " <button title='Complete' id='complete-modal-btn' class='btn btn-success text-light fs-5'>
													<i class='fa-solid fa-circle-check'></i>
												</button>";
											}

											if ($_SESSION["priviledges"]["can_assign"]) {
												echo "<button title='Assign' id='assign-modal-btn' class='btn bg-blue text-light fs-5'>
													<i class='fa-solid fa-pen'></i>
												</button> ";
											}

											if ($_SESSION["priviledges"]["can_approve"]) {
												echo "<button title='Approve' id='approve-modal-btn' class='btn btn-success text-light fs-5'>
													<i class='fa-solid fa-thumbs-up'></i>
												</button>";
											}

											if ($_SESSION["priviledges"]["can_delete"]) {
												echo " <button title='Delete' id='caution-modal-btn' class='btn btn-danger text-light fs-5'>
													<i class='fa-solid fa-trash-can'></i>
												</button>";
											}
											
											
											
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
								
								
							<?php include("../../modules/pagination.php") ?>
								
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

		// details modal
		if (element.querySelector('#details-modal-btn')) {
			element.querySelector('#details-modal-btn').addEventListener('click', () => {
				let suffix = "<?php echo (!empty($_GET)) ? "&" : "?"; ?>";
				window.location.href += suffix + "ticket_details=" + element.querySelector('#ticket-number').innerHTML;
			});	
		}
		

		// edit modal operations
		if (element.querySelector('#update-modal-btn')) {
			element.querySelector('#update-modal-btn').addEventListener('click', () => {
				if (element.querySelector('#status').innerHTML == "PENDING") {
					window.location.href = "update-ticket.php?ticket_number=" + element.querySelector('#ticket-number').innerHTML;
				}
				else {
					show_modal("update_error", element.querySelector('#ticket-number').innerHTML);
				}
			});

		}

		// delete modal operations
		if (element.querySelector('#caution-modal-btn')) {
			element.querySelector('#caution-modal-btn').addEventListener('click', () => {
				let usertype = "<?php echo $_SESSION["user_type"] ?>";
				if (element.querySelector('#status').innerHTML == "CLOSED") {
					show_modal("delete_caution", element.querySelector('#ticket-number').innerHTML);
				}
				else if ( usertype == "USER" && element.querySelector('#status').innerHTML == "PENDING") {
					show_modal("delete_caution", element.querySelector('#ticket-number').innerHTML);
				}
				else {
					show_modal("delete_error", element.querySelector('#ticket-number').innerHTML);
				}
			});

		}

		// approve modal operations
		if (element.querySelector('#approve-modal-btn')) {
			element.querySelector('#approve-modal-btn').addEventListener('click', () => {
				if (element.querySelector('#status').innerHTML == "CLOSED") {
					show_modal("approve_error_closed", element.querySelector('#ticket-number').innerHTML);
				}

				else if (element.querySelector('#status').innerHTML == "FOR APPROVAL") {
					show_modal("approve_caution", element.querySelector('#ticket-number').innerHTML);
				}
				else {
					show_modal("approve_error", element.querySelector('#ticket-number').innerHTML);
				}
			});
		}
		

		// complete modal operations
		if (element.querySelector('#complete-modal-btn')) {
			element.querySelector('#complete-modal-btn').addEventListener('click', () => {
				if (element.querySelector('#status').innerHTML == "ON-GOING") {
					show_modal("complete_caution", element.querySelector('#ticket-number').innerHTML);
				}
				else {
					show_modal("complete_error", element.querySelector('#ticket-number').innerHTML);
				}
			});
		}

		// assign modal operations
		if (element.querySelector('#assign-modal-btn')) {
			element.querySelector('#assign-modal-btn').addEventListener('click', () => {
				if (element.querySelector('#status').innerHTML == "PENDING" || element.querySelector('#status').innerHTML == "ON-GOING") {
					window.location.href = "assign-ticket.php?ticket_number=" + element.querySelector('#ticket-number').innerHTML;
				}
				else {
					show_modal("assign_error", element.querySelector('#ticket-number').innerHTML);
				}
			});
		}

		
	});


	function delete_ticket() {
		window.location.href = "delete-ticket.php?ticket_number=" + document.getElementById('ticket-placeholder').innerHTML;
	}

	function complete_ticket() {
		window.location.href = "complete-ticket.php?ticket_number=" + document.getElementById('ticket-placeholder').innerHTML;
	}

	function approve_ticket() {
		window.location.href = "approve-ticket.php?ticket_number=" + document.getElementById('ticket-placeholder').innerHTML;
	}


	// table alternate colors
	const rows = document.getElementById("account-table").childNodes[1].childNodes;
	for (var i = 0; i < rows.length; i++) {
		if (i%2 == 0) {
			rows[i].classList.add("bg-blue-50");
		}
	}

	// closing details modal
	const details_modal = document.getElementById("details-modal").addEventListener('click', (e) => {
		if (Array.from(e.target.classList).includes("modal")) {

			<?php 
				$new_query_string = http_build_query(array_merge($_GET,array('ticket_details' => null)));

				$prefix = (!empty($new_query_string)) ? "?" : "";

				$url = htmlspecialchars($_SERVER["PHP_SELF"]) . $prefix . $new_query_string;

				echo "window.location.href = '" . $url . "'";
			?>

		}
	})
	
</script>s
</html>
