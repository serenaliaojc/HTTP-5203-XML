<?php 

if (isset($_POST['edit_submit'])) {

	$ticket_id = $_POST['id'];

	$tickets = simplexml_load_file('tickets.xml');
	$ticket = $tickets->xpath("/tickets/ticket[@id=".$ticket_id."]");
	$ticket = $ticket[0];
} 

function dropdownList($itemList, $value) {
	foreach ($itemList as $item) {
		echo "<option value='".$item."'";
		if ($item==$value) {
			echo " selected='selected'";
		}
		echo ">".$item."</option>";
	}
}

if (isset($_POST['ticket_edit_submit'])) {

	$ticket_id = $_POST['id'];
	$ticket_priority = $_POST['priority'];
	$ticket_category = $_POST['category'];
	$ticket_status = $_POST['status'];

	$tickets = simplexml_load_file('tickets.xml');
	$ticket = $tickets->xpath("/tickets/ticket[@id=".$ticket_id."]");
	$ticket = $ticket[0];

	$ticket['priority'] = $ticket_priority;
	$ticket->category = $ticket_category;
	$ticket['status'] = $ticket_status;

	if (isset($_POST['comment'])) {

		$staff_comment = $_POST['comment'];
		$staff_id = $_COOKIE['uid'];

		$users = simplexml_load_file('users.xml');
		$staff = $users->xpath("/users/user[@id='".$staff_id."']");
		$staff = $staff[0];

		if (!isset($ticket->messages)) {
			$ticket->addChild('messages','');
		}

		$message = $ticket->messages->addChild('message','');
		$message->addChild('content',$staff_comment);
		$assignedstaff = $message->addChild('assignedstaff','');
		$assignedstaff->addChild('id',$staff_id);
		$assignedstaff->addChild('firstname',$staff->name->firstname);
		$assignedstaff->addChild('lastname',$staff->name->lastname);

	}

	$tickets->saveXML("tickets.xml");
	header("Location:admin-list.php");
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Ticket Edit</title>
 	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>
 <body>
 	<div class="container">
 		<div class="border border-primary rounded p-4 m-4">
 			<h1>Ticket <?php echo $ticket['id']; ?></h1>
 			<div>
 				<h2 class="text-secondary m-3">Ticket Information</h2>
 				<form action="ticket-edit.php" method="post">
 					<input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
 					<div class="row form-group m-2">
 						<label for="priority" class="col-sm-2 col-form-label font-weight-bold">Priority</label>
 						<select name="priority" id="priority" class="col-sm-3 form-control text-uppercase">
 							<?php 
 								$priorityList = ['low','medium','high'];
 								dropdownList($priorityList,$ticket['priority']);
 							 ?>
 						</select>
 					</div>
 					<div class="row form-group m-2">
 						<label for="category" class="col-sm-2 col-form-label font-weight-bold">Category</label>
 						<select name="category" id="category" class="col-sm-3 form-control">
 							<?php 
 								$categoryList = ['Technical','Complaint','Inquire'];
 								dropdownList($categoryList,$ticket->category);
 							 ?>
 						</select>
 					</div>
 					<div class="row form-group m-2">
 						<label for="status" class="col-sm-2 col-form-label font-weight-bold">Status</label>
 						<select name="status" id="status" class="col-sm-3 form-control text-uppercase">
 							<?php 
 								$statusList = ['pending','assigned','closed'];
 								dropdownList($statusList,$ticket['status']);
 							 ?>
 						</select>
 					</div>
 					<div class="row form-group m-2">
 						<label for="submitdate" class="col-sm-2 col-form-label font-weight-bold">Submit Time</label>
 						<input type="text" name="submitdate" class="col-sm-3 form-control" readonly value="<?php echo str_replace("T"," ",$ticket->submitdate); ?>">
 					</div>
 					<div class="row form-group m-2">
 						<label for="user" class="col-sm-2 col-form-label font-weight-bold">User</label>
 						<input type="text" name="user" class="col-sm-3 form-control" readonly value="<?php echo $ticket->user->username; ?>">
 					</div>
 					<div class="row form-group m-2">
 						<label for="description" class="col-sm-2 col-form-label font-weight-bold">Description</label>
 						<input type="text" name="description" class="col-sm-8 form-control" readonly value="<?php echo $ticket->description; ?>">
 					</div>
 					<div class="row form-group m-2">
 						<label for="comment" class="col-sm-2 col-form-label font-weight-bold">Your Comment</label>
 						<input type="text" name="comment" class="col-sm-8 form-control">
 					</div>
 					<input type="submit" name="ticket_edit_submit" class="btn btn-outline-primary ml-5" value="Submit">
 				</form>
 			</div>

 			<?php 

 			if (isset($ticket->messages)) {
 				echo "<div>
			 		<h2 class='text-secondary m-3'>Staff Reply</h2>";
			 	foreach ($ticket->messages->message as $message) {
			 		echo "<div class='row m-2'>
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