<?php

header('Content-Type:application/json');
$app->get('/api/defaultview/{page}', function($request){
   	require_once('conn.php');
      $id = $request->getAttribute('page');
      $id = str_replace("_"," and ",$id);
    
   			$query = "select 
                      s.id as specie_id, 
	   					 s.l_name,
	   					 s.r_name, 
	   					 s.description,
	   					 s.image_url, 
	   					 s.origin,
	   					 s.id_genus as genus_id,
                      g.l_name as genus,
	   					 f.id as family_id,
	   					 f.l_name as family
	   					 from species as s, family as f, genus as g
	   					 	where s.id_genus = g.id and g.id = f.id and s.id between ? order by s.id ASC";

      $query = str_replace('?', $id, $query);	   					 	

   				$result = $mysqli->query($query);
   				$species_default = array();
   				$specie_array = array();


   				while ($row_species = mysqli_fetch_assoc($result)){

   					foreach ($row_species as $key => $value) {
   						$specie_array[$key] = $value;

   						
   					}
   					
                  array_push($species_default, $specie_array);
   					
   				}


           
   				$json = json_encode($species_default, JSON_PRETTY_PRINT);

				  return $json;

   	});