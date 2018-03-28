<?php 

if (!isset($_COOKIE['uid'])) {
	header("Location:login.php");
}

$alert = "";

if (isset($_POST['ticket_add_submit'])) {

	if (isset($_POST['description']) && $_POST['description'] != "") {

		$ticket_category = $_POST['category'];
		$ticket_description = $_POST['description'];

		$tickets = simplexml_load_file('tickets.xml');
		$users = simplexml_load_file('users.xml');

		$ticket_id = count($tickets->ticket)+1;
		$ticket_uname = $users->xpath("/users/user[@id='".$_COOKIE['uid']."']");

		$ticket = $tickets->addChild('ticket','');
		$ticket->addAttribute('id',$ticket_id);
		$ticket->addAttribute('status','pending');
		$ticket->addAttribute('priority','low');
		$ticket->addChild('submitdate',date("Y-m-d\TH:i:s"));
		$ticket->addChild('category',$ticket_category);
		$ticket->addChild('user','');
		$ticket->user->addChild('id',$_COOKIE['uid']);
		$ticket->user->addChild('username',$ticket_uname[0]->name->username);
		$ticket->addChild('description',$ticket_description);

		$tickets->saveXML("tickets.xml");
		header("Location:client-list.php");

	} else {
		$alert = "Please give us some brief description.";
	}
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Ticket</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<h1>Add New Ticket</h1>
		<form action="ticket-add.php" method="post">
			<div class="row form-group m-2">
				<label for="category" class="col-sm-2 col-form-label font-weight-bold">Category</label>
				<select name="category" id="category" class="col-sm-3 form-control">
					<option value="Technical">Technical</option>
					<option value="Complaint">Complaint</option>
					<option value="Inquire">Inquire</option>
				</select>
			</div>
			<div class="row form-group m-2">
				<label for="description" class="col-sm-2 col-form-label font-weight-bold">Description</label>
				<input type="text" name="description" class="col-sm-8 form-control">
			</div>
			<input type="submit" name="ticket_add_submit" class="btn btn-outline-primary ml-4 mr-2" value="Submit">
			<span class="text-danger">
			  <?php echo $alert; ?>
			</span>
		</form>
	</div>
</body>
</html>