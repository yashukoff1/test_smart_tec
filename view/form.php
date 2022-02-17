<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<form action="index.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="exampleFormControlFile1">CSV file input</label>
	    <input type="file" class="form-control-file" id="csv_file" name="csv_file">
	  </div>
	  <button type="submit" class="btn btn-primary">Загрузить</button>
	</form>
</body>
</html>