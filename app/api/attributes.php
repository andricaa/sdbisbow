<?php

header('Content-Type:application/json');
$app->get('/api/attribute', function(){
   	require_once('conn.php');

   		$query = "select s.conservation, s.soil, s.termic_resistance, s.color from species as s";




   		$result = $mysqli->query($query);
   		$attribute = array();
   		$attributes = array();
   			while ($row_species = mysqli_fetch_assoc($result)){

   					foreach ($row_species as $key => $value) {
   						$attribute[$key] = $value;	
   					}
   					
   					array_push($attributes, $attribute);
                 
   				}
   				

   		$json = json_encode($attributes, JSON_PRETTY_PRINT);
   		printf("<pre>%s</pre>", $json);
		 return $json;



   });