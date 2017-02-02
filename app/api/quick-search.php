<?php

header('Content-Type:application/json');
$app->get('/api/quick-search/{keyword}', function($request){
   	require_once('conn.php');
      $keyword = $request->getAttribute('keyword');
      $keyword = strtolower($keyword);
    
   			$query = "select 
                      s.id as specie_id, 
	   					 s.l_name,
	   					 s.r_name, 
	   					 s.description,
	   					 s.image_url, 
	   					 s.origin,
	   					 s.id_genus as genus_id,
                         s.l_name as genus,
	   					 f.id as family_id,
	   					 f.l_name as family
	   					 from species as s, family as f, genus as g
	   					 	where s.id_genus = g.id and g.id = f.id and  s.id in (select id_specie from keyword where value like '%?%' ) order by s.id ASC";

      $query = str_replace('?', $keyword, $query);	   					 	

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
