<?php
	$kawalcoronaKecamatan = file_get_contents("./data/covid19kecstat.json");
  $kasusKecamatan = json_decode($kawalcoronaKecamatan, TRUE);

  $geojsonKecamatan = file_get_contents("./data/kecamatan_point.json");
  $pointKecamatan = json_decode($geojsonKecamatan, TRUE);

  
	foreach ($pointKecamatan['features'] as $key => $first_value) {
    foreach ($kasusKecamatan as $second_value) {
      if($first_value['properties']['kode_join']==$second_value['attributes']['kode_join']){
        $pointKecamatan['features'][$key]['properties']['Kasus_Aktif'] = $second_value['attributes']['kasus_aktif'];
      	$pointKecamatan['features'][$key]['properties']['Kasus_Positif'] = $second_value['attributes']['kasus_posi'];
      	$pointKecamatan['features'][$key]['properties']['Kasus_Sembuh'] = $second_value['attributes']['kasus_semb'];
      	$pointKecamatan['features'][$key]['properties']['Kasus_Meninggal'] = $second_value['attributes']['kasus_meni'];
    	} else {}
		}
	}
	$combined_output = json_encode($pointKecamatan, JSON_NUMERIC_CHECK); 

	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	echo $combined_output;
?>
