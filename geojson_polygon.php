<?php
	$kawalcoronaKecamatan = file_get_contents("http://localhost/api/kecamatan.json");
  $kasusKecamatan = json_decode($kawalcoronaKecamatan, TRUE);

  $geojsonKecamatan = file_get_contents("http://geoportal.kukarkab.go.id:8080/geoserver/q_bidang_kesehatan/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=q_bidang_kesehatan%3Akecamatan_polygon&maxFeatures=18&outputFormat=application%2Fjson");
  $pointKecamatan = json_decode($geojsonKecamatan, TRUE);

  
	foreach ($pointKecamatan['features'] as $key => $first_value) {
    foreach ($kasusKecamatan as $second_value) {
      if($first_value['properties']['kode_join']==$second_value['attributes']['kode_join']){
        $pointKecamatan['features'][$key]['properties']['Kasus_Aktif'] = $second_value['attributes']['Kasus_Aktif'];
      	$pointKecamatan['features'][$key]['properties']['Kasus_Positif'] = $second_value['attributes']['Kasus_Posi'];
        $pointKecamatan['features'][$key]['properties']['Kasus_Sembuh'] = $second_value['attributes']['Kasus_Semb'];
        $pointKecamatan['features'][$key]['properties']['Kasus_Meninggal'] = $second_value['attributes']['Kasus_Meni'];
    	} else {}
		}
	}
	$combined_output = json_encode($pointKecamatan);

	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	echo $combined_output;
?>