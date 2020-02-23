<?php
	date_default_timezone_set("Asia/Jakarta");
	require 'function_update.php';

	mysql_connect('localhost', 'root', 'mysql');
	mysql_select_db('db_bidpropam');

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

			//jabatan update
			if (trim($_POST['personel']['nama_jabatan']) == trim($jabatan_request['jabatan'])) {

				$idJab = jabatan_cat(trim($jabatan_request['jabatan']));
				if($idJab['error'] == false) {
					$idTempat = tempat_cat(trim($jabatan_request['satker']));
					if ($idTempat['error'] == false) {
						$cekJab = mysql_query("SELECT * FROM jabatan WHERE jabId = '".$idJab['jabatan']['idJabatan']."'");

						$temukan = mysql_num_rows($cekJab);

						if ($temukan < 1) {
							$time = time();
							//buat data jabatan
							mysql_query("INSERT INTO jabatan(jabId, 
															nmJabatan, 
															kesatuanId, 
															status, 
															timeCreated) 
												VALUES('".$idJab['jabatan']['idJabatan']."', 
													'".$idJab['jabatan']['nama_jabatan']."', 
													'".$idTempat['tempat']['idTempat']."', 
													1, 
													".$time.")");

							$result = [
						        'failed' => 0,
						        'nrp' => $personel_cr['nrp'], 
						        'nama' => $personel_cr['nama'], 
						        'color' => 'text-success', 
						        'message' => 'jabatan telah ditambahkan'
							];
						} else {
							$result = [
						        'failed' => 0,
						        'nrp' => $personel_cr['nrp'], 
						        'nama' => $personel_cr['nama'], 
						        'color' => 'text-warning', 
						        'message' => 'jabatan sudah ada di database'
							];
						}

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
			        'message' => 'Jabatan tidak digunakan'
				];	
			}

			
		} else {
			$result = [
		        'failed' => 1,
		        'nrp' => $_POST['personel']['nrp'], 
		        'nama' => $_POST['personel']['nama'], 
		        'color' => 'text-danger', 
		        'message' => 'sudah pindah'
			];
			

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