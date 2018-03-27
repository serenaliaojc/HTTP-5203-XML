<?php 

if (isset($_POST['details_submit'])) {

	$ticket_id = $_POST['id'];

	$tickets = simplexml_load_file('tickets.xml');
	$ticket = $tickets->xpath("/tickets/ticket[@id=".$ticket_id."]");
	$ticket = $ticket[0];

} else {
	header("Location:login.php");
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Ticket Details</title>
 	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 	<style type="text/css">
 		.low {
 			color: gray;
 		}
 		.medium {
 			color: blue;
 		}
 		.high {
 			color: red;
 		}
 		.pending {
 			color: green;
 		}
 		.assigned {
 			color: orange;
 		}
 		.closed {
 			color: gray;
 		}
 	</style>
 </head>
 <body>
 	<div class="container">
 		<div class="border border-info rounded p-4 m-4">
 			<h1>Ticket <?php echo $ticket['id']; ?></h1>
 			<div>
 				<h2 class="text-secondary">Ticket Information</h2>
 				<form>
 					<div class="row form-group m-0">
 						<label for="priority" class="col-sm-2 col-form-label font-weight-bold">Priority</label>
 						<input type="text" name="priority" class="col-sm-3 form-control-plaintext <?php echo $ticket['priority']; ?> text-uppercase" readonly value="<?php echo $ticket['priority']; ?>">
 					</div>
 					<div class="row form-group m-0">
 						<label for="category" class="col-sm-2 col-form-label font-weight-bold">Category</label>
 						<input type="text" name="category" class="col-sm-3 form-control-plaintext" readonly value="<?php echo $ticket->category; ?>">
 					</div>
 					<div class="row form-group m-0">
 						<label for="status" class="col-sm-2 col-form-label font-weight-bold">Status</label>
 						<input type="text" name="status" class="col-sm-3 form-control-plaintext <?php echo $ticket['status']; ?> text-uppercase" readonly value="<?php echo $ticket['status']; ?>">
 					</div>
 					<div class="row form-group m-0">
 						<label for="submitdate" class="col-sm-2 col-form-label font-weight-bold">Submit Time</label>
 						<input type="text" name="submitdate" class="col-sm-3 form-control-plaintext" readonly value="<?php echo str_replace("T"," ",$ticket->submitdate); ?>">
 					</div>
 					<div class="row form-group m-0">
 						<label for="user" class="col-sm-2 col-form-label font-weight-bold">User</label>
 						<input type="text" name="user" class="col-sm-3 form-control-plaintext" readonly value="<?php echo $ticket->user->username; ?>">
 					</div>
 					<div class="row form-group m-0">
 						<label for="description" class="col-sm-2 col-form-label font-weight-bold">Description</label>
 						<input type="text" name="description" class="col-sm-10 form-control-plaintext" readonly value="<?php echo $ticket->description; ?>">
 					</div>
 				</form>
 			</div>

 			<?php 

 			if (isset($ticket->messages)) {
 				echo "<div>
			 		<h2 class='text-secondary'>Staff Reply</h2>";
			 	foreach ($ticket->messages->message as $message) {
			 		echo "<div class='row m-0'>
	 					<span class='col-sm-2 font-weight-bold'>".$message->assignedstaff->firstname." ".$message->assignedstaff->lastname."</span>
	 					<span class='col-sm-10'>".$message->content."</span>
	 				</div>";
			 	}
			 	echo "</div>";
 			}
 			 ?>
		 	
 		</div>
 	</div>
 </body>
 </html>