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

		$cekJab = mysql_query("SELECT * FROM personel WHERE personelId = '".$_POST['personel']['idPersonel']."'");

		$temukan = mysql_num_rows($cekJab);

		if ($temukan < 1) {
			$time = time();
			//buat data jabatan
			mysql_query("INSERT INTO personel(personelId, 
											nrp, 
											nama, 
											tmpLahir, 
											tglLahir, 
											kesatuanId, 
											jabId, 
											pangkatId, 
											status, 
											foto, 
											timeCreated, 
											timeUpdated) 
								VALUES('".$_POST['personel']['idPersonel']."', 
									'".$_POST['personel']['nrp']."', 
									'".mysql_real_escape_string($_POST['personel']['nama'])."', 
									'".mysql_real_escape_string($_POST['personel']['tmp_lahir'])."', 
									'".$_POST['personel']['tgl_lahir']."', 
									'".$_POST['personel']['idTempat']."', 
									'".$_POST['personel']['idJabatan']."', 
									'".$_POST['personel']['idPangkat']."', 
									'".$_POST['personel']['status']."', 
									'default.jpg', 
									".$time.", 
									".$time.")");

			$result = [
		        'failed' => 0,
		        'nrp' => $_POST['personel']['nrp'], 
		        'nama' => $_POST['personel']['nama'], 
		        'color' => 'text-success', 
		        'message' => 'personel telah ditambahkan'
			];
		} else {
			$result = [
		        'failed' => 3,
		        'nrp' => $_POST['personel']['nrp'], 
		        'nama' => $_POST['personel']['nama'], 
		        'color' => 'text-warning', 
		        'message' => 'personel di update'
			];
		}

		
	} else {
		$result = [
	        'failed' => 1,
	        'nrp' => $_POST['personel']['nrp'], 
		    'nama' => $_POST['personel']['nama'], 
	        'color' => 'text-danger', 
	        'message' => 'Not found'
		];

		
	}

	echo json_encode($result);
		
?>