<?php
header('Content-Type:application/json');
$app->get('/api/counts', function(){
   	require_once('conn.php');
   		$count;
   		$query = "select count(*) FROM species";
   		$result = $mysqli->query($query);
   		while($row = mysqli_fetch_assoc($result)){

   			$count = $row['count(*)'];
   		};

   		$json = json_encode($count, JSON_PRETTY_PRINT);
   		return $json;
   	
 });