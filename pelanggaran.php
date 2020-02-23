<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoring Update Data Pelanggaran</title>


    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
</head>
<body>
	<div class="container">
		
		<div class="row">
			<div class="col-lg">
				<h2>Data Pelanggaran</h2>
				<div class="table-responsive" style="height: 500px;">
				<?php
					require 'function_update.php';

					mysql_connect('localhost', 'root', 'mysql');
					mysql_select_db('db_bidpropam');

					$totalpel = total_pelanggaran_cat();
					
					$per_page = 1000;
					$jumlahHalaman = ceil($totalpel/$per_page);
					
					$page = isset($_GET['start']) ? (int)$_GET["start"] : 0;
					$mulai = ($page>1) ? ($page - 1) * $per_page : 0;

					if (isset($_GET['start'])) {	
						$data_all = gocatpel_perpage($mulai, $per_page);
					}

					// var_dump($data_all);die;

					// var_dump($data_all);die;
					echo"<table class='table table-bordered table-striped table-hover'>
						<thead>
						<tr>
							<th>#</th>
							<th>Data Pelanggaran</th>
						</tr>
						</thead>
						<tbody>";
						$total_sama = 0;
						$total_beda = 0;

						$ganti_jab = 0;

						$total_import = 0;
						$total_imported = 0;

					foreach ($data_all as $pers) {
						$idpelanggaran = $pers['idPelanggaran'];
						$jab = "";
						$sat = "";

						//cek apakah jabatan sudah sama atau belum
						$cekdata = mysql_query("SELECT * FROM jabatan WHERE jabId = '".$pers['idJabatan']."'");
						$temukan = mysql_num_rows($cekdata);

						if($temukan > 0) {
							$total_sama = $total_sama + 1;
							$img_jab = 'check.png';

							$jab = $pers['idJabatan'];
							$sat = $pers['idTempat'];

						} else {
							// $time = time();
							// mysql_query("INSERT INTO jabatan(jabId, 
							// 																nmJabatan, 
							// 																kesatuanId, 
							// 																status, 
							// 																timeCreated) 
							// 													VALUES(
							// 													'".$pers['idJabatan']."', 
							// 													'".$pers['nama_jabatan']."', 
							// 													'".$pers['idTempat']."', 
							// 													1, 
							// 													$time)");
							$qCekper = mysql_query("SELECT * FROM personel WHERE personelId = '".$pers['idPersonel']."'");
							$ctemukan = mysql_num_rows($qCekper);
							if ($ctemukan > 0) {
								$ganti_jab = $ganti_jab + 1;
								$per = mysql_fetch_assoc($qCekper);
								$jab = $per['jabId'];
								$sat = $per['kesatuanId'];
								$img_jab = 'warning.png';	
							} else {
								$jab = "";
								$sat = "";
								$img_jab = 'cross_circle.png';	
							}

							$total_beda = $total_beda + 1;
							
						}

						//cek jenis pelanggaran
						$cekJenis = mysql_query("SELECT * FROM pelanggaran_jenis WHERE singkatan = '".$pers['idJenis']."'");
						$temukanJ = mysql_num_rows($cekJenis);
						if ($temukanJ > 0) {
							$jenis = mysql_fetch_assoc($cekJenis);
							$jenis_pel = $jenis['jenisId'];
						} else {
							$jenis_pel = '';
						}

						//import pelanggaran
						$timeC = time();
						$timeU = time();
						$cekPel = mysql_query("SELECT * FROM pelanggaran WHERE pelanggaranId = '".$idpelanggaran."'");
						$temukanPel = mysql_num_rows($cekPel);
						if ($temukanPel < 1) {
							
							mysql_query("INSERT INTO pelanggaran(
															pelanggaranId, 
															referensi, 
															uraian, 
															tgldiLapor, 
															pasal, 
															rekomendasi, 
															tglRekom, 
															personelId, 
															jenisId, 
															kesatuanId, 
															jabId, 
															pangkatId, 
															keterangan, 
															hukuman, 
															tglSidang, 
															tglSurat, 
															noSurat, 
															status, 
															timeCreated, 
															timeUpdated
														)
													VALUES(
														'".$pers['idPelanggaran']."', 
														'".mysql_real_escape_string($pers['referensi'])."', 
														'".mysql_real_escape_string($pers['uraian'])."', 
														'".$pers['tgl_dilapor']."', 
														'".mysql_real_escape_string($pers['pasal'])."', 
														'".mysql_real_escape_string($pers['rekomendasi'])."', 
														'".$pers['tgl_rekomendasi']."', 
														'".$pers['idPersonel']."', 
														'".$jenis_pel."', 
														'".$sat."', 
														'".$jab."', 
														'".$pers['idPangkat']."', 
														'".mysql_real_escape_string($pers['keterangan'])."', 
														'".mysql_real_escape_string($pers['hukuman'])."', 
														'".$pers['tgl_sidang']."', 
														'".$pers['tgl_surat']."', 
														'".mysql_real_escape_string($pers['no_surat'])."', 
														".$pers['status'].", 
														".$timeC.", 
														".$timeU."
													)") or die(mysql_error());

							$total_import = $total_import + 1;
						} else {
							mysql_query("UPDATE pelanggaran SET jenisId = ".$jenis_pel.", 
																jabId = '".$jab."', 
																kesatuanId = '".$sat."', 
																timeUpdated = ".$timeU." 
										WHERE pelanggaranId = '".$idpelanggaran."'") or die(mysql_error());

							$total_imported = $total_imported + 1;
						}

						echo"<tr>
							<td>".++$mulai."</td>
							<td>
								NRP: ".$pers['idPersonel']."<br>
								ID Jabatan:  <img src='images/".$img_jab."'> - ".$jab."<br>
								Nama Jabatan: ".$pers['nama_jabatan']." <img src='images/".$img_jab."'>
							</td>
						</tr>";
						
					}
					echo"</tbody>
					</table>";

					//var_dump($personel_arr);
				?>

				
				</div>
				<?= "Total Data: " .$totalpel. " 
				| " ."Total Sama :".$total_sama." 
				| Total Beda : ".$total_beda." 
				| Total Ganti : ".$ganti_jab." 
				| " ."Total Import :".$total_import."
				| " ."Total Imported :".$total_imported
				; ?>
			</div>
		</div>

	</div>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>