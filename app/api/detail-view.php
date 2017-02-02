<?php
header('Content-Type:application/json');
$app->get('/api/detail-view/{id}', function($request){
   	require_once('conn.php');
   	$id = $request->getAttribute('id');

//load details

   	$query = "select s.id, 
   					 s.l_name,
   					 s.r_name, 
   					 s.description, 
   					 s.image_url,
   					 s.conservation,
   					 s.soil, 
   					 s.termic_resistance,
   					 s.origin,
   					 s.color,
   					 s.min_altitude, 
   					 s.max_altitude, 
   					 s.id_genus
   					 from species as s where s.id = ?
   					 	order by s.id ASC";

   	$query = str_replace('?', $id, $query);	
   	$result = $mysqli->query($query);
   	$species_all = array();
   	$specie_array = array();
   	$details_array = array();
   	$values_array = array();
   	$images = array();
   	
	 while ($row_species = mysqli_fetch_assoc($result)){
	 		$specie_array['id'] = $row_species['id'];
	 		$specie_array['r_name'] = $row_species['r_name'];
	 		$specie_array['description'] = $row_species['description'];
	 		$specie_array['conservation'] = $row_species['conservation'];
	 		$specie_array['image_url'] = $row_species['image_url'];
	 		$specie_array['soil'] = $row_species['soil'];
	 		$specie_array['termic_resistance'] = $row_species['termic_resistance'];
	 		$specie_array['origin'] = $row_species['origin'];
	 		$specie_array['color'] = $row_species['color'];
	 		$specie_array['min_altitude'] = $row_species['min_altitude'];
	 		$specie_array['max_altitude'] = $row_species['max_altitude'];
	 		$specie_array['id_genus'] = $row_species['id_genus'];
	 		$specie_array['details'] = array();
	 		$specie_array['images'] = array();

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


		//load images		
				
					$query_image = "select
										i.id_image,
										i.id_specie,
										i.image_url
											from image as i where i.id_specie = $id";


					$q_image = $mysqli->query($query_image);
					
								while ($row_values = mysqli_fetch_assoc($q_image)) {
									
										$images['id_image'] = $row_values['id_image'];
										$images['id_specie'] = $row_values['id_specie'];
										$images['image_url'] = $row_values['image_url'];
										
										
										array_push($specie_array['images'],$images);	

								
								}	
		 		
		 		
				array_push($species_all,$specie_array);



					 	

				
		}
		 




		

	$json = json_encode($species_all, JSON_PRETTY_PRINT);


	return $json;

				
		
});

