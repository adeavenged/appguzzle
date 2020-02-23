<?php
	date_default_timezone_set("Asia/Jakarta");
	require 'function_update.php';
	$personel = count($_POST['personel']);

	$result = [
        'failed' => 1,
        'nrp' => '', 
	    'nama' => '', 
        'color' => '', 
        'message' => 'Not found'
	];

	if($personel > 0) {
		$idpersonel = $_POST['personel']['idPersonel'];
		$personel_cr = data_personel_sip($_POST['personel']['nrp'])['data'];
		
		if(count($personel_cr) > 0) {
			$jabatan_request = jabatan_req($personel_cr['jabatan']);	

			//pangkat update
			// $idPangkat = '';
			// if (trim($_POST['personel']['nama_pangkat']) != trim($personel_cr['pangkat'])) {
			// 	$idPangkat = pangkat_cat($personel_cr['pangkat'])['idPangkat'];
			// 	$data = [
			// 		'tmt_pangkat' => date('Y-m-d'),
			// 		'idPersonel' => $idpersonel, 
			// 		'idPangkat' => $idPangkat, 
			// 		'api-key' => 'catpers123'
			// 	];

			// 	$simpanpang = simpan_riwpangkat_cat($data);

			// 	if ($simpanpang['status'] == true) {
			// 		$result = [
			// 	        'failed' => 0,
			// 	        'nrp' => $personel_cr['nrp'], 
			// 	        'nama' => $personel_cr['nama'], 
			// 	        'color' => 'text-success', 
			// 	        'message' => 'pangkat di update'
			// 		];
			// 	} else {
			// 		$result = [
			// 	        'failed' => 1,
			// 	        'nrp' => $personel_cr['nrp'], 
			// 	        'nama' => $personel_cr['nama'], 
			// 	        'color' => 'text-warning', 
			// 	        'message' => 'pangkat gagal di update'
			// 		];
			// 	}	

			// }

			//jabatan update
			if (trim($_POST['personel']['nama_jabatan']) != trim($jabatan_request['jabatan'])) {
				$idJab = jabatan_cat(trim($jabatan_request['jabatan']));
				if($idJab['error'] == false) {
					$idTempat = tempat_cat(trim($jabatan_request['satker']));
					if ($idTempat['error'] == false) {
						$datajab = [
							'tgl_sk' => date('Y-m-d'),
							'idJabatan' => $idJab['jabatan']['idJabatan'], 
							'idTempat' => $idTempat['tempat']['idTempat'], 
							'idPersonel' => $idpersonel, 
							'api-key' => 'catpers123'
						];

						$simpanjab = simpan_riwjabatan_cat($datajab);
						

						if ($simpanjab['status'] == true) {
							$result = [
						        'failed' => 0,
						        'nrp' => $personel_cr['nrp'], 
						        'nama' => $personel_cr['nama'], 
						        'color' => 'text-success', 
						        'message' => 'jabatan :'.$idJab['jabatan']['nama_jabatan'].' di update'
							];
						} else {
							$result = [
						        'failed' => 1,
						        'nrp' => $personel_cr['nrp'], 
						        'nama' => $personel_cr['nama'], 
						        'color' => 'text-danger', 
						        'message' => 'jabatan gagal di update'
							];
						}
						// $result = [
					 //        'failed' => 0,
					 //        'nrp' => $personel_cr['nrp'], 
					 //        'nama' => $personel_cr['nama'], 
					 //        'color' => 'text-success', 
					 //        'message' => 'jabatan :'.$datajab['idPersonel'].' di update'
						// ];	
					} else {
						$result = [
					        'failed' => 0,
					        'nrp' => $personel_cr['nrp'], 
					        'nama' => $personel_cr['nama'], 
					        'color' => 'text-warning', 
					        'message' => 'Message :'.$idTempat['message']
						];
					}
				} else {
					$result = [
				        'failed' => 0,
				        'nrp' => $personel_cr['nrp'], 
				        'nama' => $personel_cr['nama'], 
				        'color' => 'text-warning', 
				        'message' => 'Message :'.$idJab['message']
					];
				}

				
			} else {
				$result = [
			        'failed' => 0,
			        'nrp' => $personel_cr['nrp'], 
			        'nama' => $personel_cr['nama'], 
			        'color' => 'text-primary', 
			        'message' => 'jabatan :'.$jabatan_request['jabatan'].' have upgraded'
				];	
			}

			
		} else {
			$datalp = [
				'idTempat' => '4181fcfa-badf-11e6-892b-7efd7b6fbc62', 
				'idPersonel' => $idpersonel, 
				'api-key' => 'catpers123'
			];

			$uplp = update_luarpolda_cat($datalp);
			if ($uplp['status'] == true) {
				$result = [
			        'failed' => 1,
			        'nrp' => $_POST['personel']['nrp'], 
			        'nama' => $_POST['personel']['nama'], 
			        'color' => 'text-warning', 
			        'message' => 'sudah pindah luar polda'
				];
			} else {
				$result = [
			        'failed' => 1,
			        'nrp' => $_POST['personel']['nrp'], 
			        'nama' => $_POST['personel']['nama'], 
			        'color' => 'text-danger', 
			        'message' => 'sudah pindah'
				];
			}
			

		}
	
		
	} else {
		$result = [
	        'failed' => 1,
	        'nrp' => $_POST['personel']['nrp'], 
		    'nama' => $_POST['personel']['nama'], 
	        'color' => 'text-warning', 
	        'message' => 'Not found'
		];

		
	}

	echo json_encode($result);
		
?>