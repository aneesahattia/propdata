<?php
include('connect.php');

$sql = "SELECT * FROM `special_offers` where so_status=1";

$fetch = $dbh->query($sql);



print "
			<table cellspacing='0' cellpadding='0' border=1>			
				<tr>				
					<th>Title</th>
					<th>Description</th>
					<th>Edit</th>					
					
				</tr>
	";
while ($row=$fetch->fetch(PDO::FETCH_ASSOC)) {
	print "
			<tr>
					<td>{$row['so_title']}</td>
					<td>{$row['so_desc']}</td>
					<td><a href='edit.php?so_id={$row['so_id']}'>EDIT</a></td>					
			</tr>

				
	  		";

	  	}

print "</table>";

	
?>