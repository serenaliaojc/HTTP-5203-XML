<?php 

if ($_COOKIE['type'] != 'admin') {
	header("Location:login.php");
}

$tickets = simplexml_load_file('tickets.xml');

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Ticket List</title>
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
 		<h1>Ticket System</h1>
	 	<h2>Ticket List</h2>
	 	<table id="admin-list" class="table table-hover">
	 		<thead>
	 			<th scope="col">Ticket ID</th>
	 			<th scope="col">Priority</th>
	 			<th scope="col">Category</th>
	 			<th scope="col">Status</th>
	 			<th scope="col">User</th>
	 			<th scope="col">Submit Time</th>
	 			<th scope="col">Details</th>
	 			<th scope="col">Edit</th>
	 		</thead>
	 		<tbody>
	 			<?php 
	 			foreach ($tickets->ticket as $ticket) {
	 				echo "<tr>
		 				<td>".$ticket['id']."</td>
		 				<td class='".$ticket['priority']." text-uppercase'>".$ticket['priority']."</td>
		 				<td>".$ticket->category."</td>
		 				<td class='".$ticket['status']." text-uppercase'>".$ticket['status']."</td>
		 				<td>".$ticket->user->username."</td>
		 				<td>".str_replace("T"," ",$ticket->submitdate)."</td>
		 				<td>
			 				<form action='ticket-detail.php' method='post'>
			 					<input type='hidden' name='id' value='".$ticket['id']."'>
			 					<input type='submit' class='btn btn-info' name='details_submit' value='Details'>
			 				</form>
			 			</td>
		 				<td>
			 				<form action='ticket-edit.php' method='post'>
			 					<input type='hidden' name='id' value='".$ticket['id']."'>
			 					<input type='submit' class='btn btn-light' name='edit_submit' value='Edit'>
			 				</form>
			 			</td>
		 			</tr>";
	 			}
	 			 ?>
	 		</tbody>
	 	</table>
	 	<form action='login.php' method='post'>
			<input type='submit' class='btn btn-secondary' name='logout' value='Logout'>
		</form>
 	</div>
 	
 </body>
 </html>