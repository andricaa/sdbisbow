<?php
header('Content-Type:application/json');
$app->get('/api/species', function(){
   	require_once('conn.php');

   	$query = "select s.id, 
   					 s.l_name,
   					 s.r_name, 
   					 s.description, 
   					 s.conservation,
   					 s.soil, 
   					 s.termic_resistance,
   					 s.origin,
   					 s.color,
   					 s.min_altitude, 
   					 s.max_altitude, 
   					 s.id_genus
   					 from species as s
   					 	order by s.id ASC";

   	
      
   	$species_all = array();
   	$specie_array = array();
   	$details_array = array();
   	$values_array = array();
   	
	 while ($row_species = mysqli_fetch_assoc($result)){
	 		$specie_array['id'] = $row_species['id'];
	 		$specie_array['r_name'] = $row_species['r_name'];
	 		$specie_array['description'] = $row_species['description'];
	 		$specie_array['conservation'] = $row_species['conservation'];
	 		$specie_array['soil'] = $row_species['soil'];
	 		$specie_array['termic_resistance'] = $row_species['termic_resistance'];
	 		$specie_array['origin'] = $row_species['origin'];
	 		$specie_array['color'] = $row_species['color'];
	 		$specie_array['min_altitude'] = $row_species['min_altitude'];
	 		$specie_array['max_altitude'] = $row_species['max_altitude'];
	 		$specie_array['id_genus'] = $row_species['id_genus'];
	 		$specie_array['details'] = array();
	 		
		 	$id = (int)$specie_array["id"];		 	
		 	$query_details = "select distinct (d.id_detail), s.id, d.d_name from species as s left join species_detail as sd on s.id = sd.id_species inner join details as d on sd.id_detail = d.id_detail where s.id = '$id' order by d.id_detail ASC";

		 		$result1 = $mysqli->query($query_details);
			 	while ($row_details = mysqli_fetch_assoc($result1)){
		 			$details_array['id'] = $row_details['id_detail'];
		 			$details_array['name'] = $row_details['d_name'];
		 			$details_array['values'] = array();
		 			
		 			
		 			$id_d = $details_array['id'];
		 			
		 			$query_values = "select distinct(sd.id),  sd.detail_name from species as s, species_detail as sd, details as d where sd.id_detail = '$id_d' and sd.id_species = '$id'";
		 			

		 			$result2 = $mysqli->query($query_values);
		 			while ($row_values = mysqli_fetch_assoc($result2)){
	 					$values_array['id'] = $row_values['id'];
		 				$values_array['detail_name'] = $row_values['detail_name'];		 				
		 				array_push($details_array['values'],$values_array);

		 			}

		 			array_push($specie_array['details'],$details_array);
		 			
				}
		 		
		 		array_push($species_all,$specie_array);
				
		}
		 

	
		
	$json = json_encode($species_all, JSON_PRETTY_PRINT);

	printf("<pre>%s</pre>", $json);



				
		
});

