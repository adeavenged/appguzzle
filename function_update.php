<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function gocatpers_perpage($start, $perpage)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/gocatpers/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'start' => $start, 
	        'perpage' => $perpage
	    ]
	]);

	$result = json_decode($response->getBody()->getContents(), true);
	// $result = $response->getBody()->getContents();

	return $result['personel'];
	
}

function gocatpel_perpage($start, $perpage)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/gocatpel/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'start' => $start, 
	        'perpage' => $perpage
	    ]
	]);

	$result = json_decode($response->getBody()->getContents(), true);
	// $result = $response->getBody()->getContents();

	return $result['pelanggaran'];
	
}

function total_pelanggaran_cat()
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/totalpel/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123'
	    ]
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result['total'];
}

function data_all_personel_perpage($start, $perpage)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/allpersonel/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'start' => $start, 
	        'perpage' => $perpage
	    ]
	]);

	$result = json_decode($response->getBody()->getContents(), true);
	// $result = $response->getBody()->getContents();

	return $result['personel'];
	
}

function data_all_personel($start)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/allpersonel/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'start' => $start
	    ]
	]);

	$result = json_decode($response->getBody()->getContents(), true);
	// $result = $response->getBody()->getContents();

	return $result['personel'];
	
}

function total_personel_cat()
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/totalpersonel/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123'
	    ]
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result['total'];
}

function jabatan_cat($jabatan)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/cekjabatan/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'jabatan' => $jabatan
	    ]
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function pangkat_cat($pangkat)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/cekpangkat/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'pangkat' => $pangkat
	    ]
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result['pangkat'];
}

function tempat_cat($tempat)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('GET', 'http://catpers.jambi.polri.go.id/api/index.php/personel/cektempat/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'api-key' => 'catpers123', 
	        'tempat' => $tempat
	    ]
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function simpan_riwpangkat_cat($data)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('POST', 'http://catpers.jambi.polri.go.id/api/index.php/personel/riwpangkat/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'form_params' => $data
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function simpan_riwjabatan_cat($data)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('POST', 'http://catpers.jambi.polri.go.id/api/index.php/personel/riwjabatan/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'form_params' => $data
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function update_luarpolda_cat($data)
{
	$client = new Client();
	// http://catpers.jambi.polri.go.id/api/index.php/personel/?api-key=catpers123&nrp=79090357
	$response = $client->request('PUT', 'http://catpers.jambi.polri.go.id/api/index.php/personel/luarpolda/', [
		'auth' => ['catpers', '1234'], 
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'form_params' => $data
	]);

	// $result = json_decode($response->getBody()->getContents(), true);
	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function data_personel_sip($nrp)
{
	$client = new Client();
	$response = $client->request('GET', 'http://sakti.jambi.polri.go.id/wsapi.php', [
		'header' => [
	        'Access-Control-Allow-Origin' => '*'
	    ],
	    'query' => [
	        'xAct' => 'sipp', 
	        'ApiKey' => 'sdmjambi132', 
	        'Q' => $nrp
	    ]
	]);

	$result = json_decode($response->getBody()->getContents(), true);

	return $result;
}

function jabatan_req($xjab)
{
	$jabatan = "";
	//explode berdasarkan polda jambi
	$jab1 = explode(" POLDA ", $xjab);

	if(count($jab1) > 1) {
		$jab2 = explode(" POLRES ", $jab1[0]);
		$jab7 = explode(" DITPOLAIRUD", $jab1[0]);
		$jab3 = explode(" DITPOLAIR", $jab1[0]);
		$jab4 = explode(" POLRESTA ", $jab1[0]);
		$jab5 = explode(" SATBRIM", $jab1[0]);
		$jab6 = explode(" SPN", $jab1[0]);
		
		
		//cek jabatan jika polres
		if(count($jab2) > 1) {
			$jabatan = $jab2[0];
			$satker = "POLRES " . $jab2[1];
			
			// echo 'jab 3 : '. $jabatan . ' - ' . $satker;

			// $polsek = explode(" POLSEK ", $jab2[0]);
			// if (count($polsek) > 1) {
			// 	$jabatan = $polsek[0];
			// 	$satker2 = "POLSEK " . $polsek[1];

			// 	echo 'jab 3 : '. $jabatan . ' - ' . $satker2 . ' - ' . $satker1;
			// } else {
			// 	$jabatan = $jab2[0];
			// 	echo 'jab 3 : '. $jabatan . ' - ' . $satker1;
			// }
			
		} elseif(count($jab3) > 1) {
			$jabatan = $jab3[0];
			$satker = "DITPOLAIR POLDA JAMBI";

			// echo 'jab 3 : '. $jabatan . ' - ' . $satker;
		} elseif(count($jab4) > 1) {
			$jabatan = $jab4[0];
			$satker = "POLRESTA " . $jab4[1];

			// echo 'jab 4 : '. $jabatan . ' - ' . $satker;
		} elseif(count($jab5) > 1) {
			$jabatan = $jab5[0];
			$satker = "SATBRIM" . $jab5[1] . " JAMBI";
			// echo 'jab 5 : '. $jabatan . ' - ' . $satker;
		} elseif(count($jab6) > 1) {
			$jabatan = $jab6[0];
			$satker = "SPN JAMBI";
			// echo 'jab 6 : '. $jabatan . ' - ' . $satker;
		} elseif(count($jab7) > 1) {
			$jabatan = $jab7[0];
			$satker = "DITPOLAIR POLDA JAMBI";
			// echo 'jab 6 : '. $jabatan . ' - ' . $satker;
		} else {
			$jabatan = $jab1[0];
			$satker = "POLDA JAMBI";
			// echo 'jab 1 : '. $jabatan . ' - ' . $satker;
		}

		$data['jabatan'] = $jabatan;
		$data['satker'] = $satker;

		return $data;
	}
}


?>