<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<table class="table table-bordered table-hover table-striped table-dark">
	  <thead>
	    <tr>
	      <th scope="col">Customer ID</th>
	      <th scope="col">Number of customer's calls within same continent</th>
	      <th scope="col">Total duration of customer's calls within same continent</th>
	      <th scope="col">Number of all customer's calls</th>
	      <th scope="col">Total duration of all customer's calls</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach ($data as $id => $row): ?>
		    <tr>
		      <th scope="row"><?php echo $id; ?></th>
		      <td><?php echo $row['same_calls']; ?></td>
		      <td><?php echo $row['total_same_duration']; ?></td>
		      <td><?php echo $row['number_of_calls']; ?></td>
		      <td><?php echo $row['total_all_duration']; ?></td>
		    </tr>
	    <?php endforeach ?>
	  </tbody>
	</table>
</body>
</html>