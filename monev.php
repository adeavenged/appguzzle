<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoring Update Data Personel</title>


    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
</head>
<body>
	<div class="container">
		
		<div class="row">
			<div class="col-lg">
				<div class="table-responsive" style="height: 600px;">
				<?php
					require 'function_update.php';
					$totalpersonel = total_personel_cat();
					
					$per_page = 1000;
					$jumlahHalaman = ceil($totalpersonel/$per_page);
					
					$page = isset($_GET['start']) ? (int)$_GET["start"] : 0;
					$mulai = ($page>1) ? ($page - 1) * $per_page : 0;

					if (isset($_GET['start'])) {	
						$data_all = data_all_personel($mulai);
					}

					// var_dump($data_all);die;
					echo"<table class='table table-bordered table-striped table-hover'>
						<thead>
						<tr>
							<th>#</th>
							<th>Data Catpers</th>
							<th>Data SIP</th>
						</tr>
						</thead>
						<tbody>";
					$personel_arr = [];
					foreach ($data_all as $pers) {
						$idpersonel = $pers['idPersonel'];
						$personel_cr = data_personel_sip($pers['nrp'])['data'];
						$jabatan_request = jabatan_req($personel_cr['jabatan']);

						if(count($personel_cr) > 0) {
							$img_nrp = ($pers['nrp'] == $personel_cr['nrp']) ? 'check.png' : 'warning.png';
							$img_nama = ($pers['nama'] == $personel_cr['nama']) ? 'check.png' : 'warning.png';
							$img_pangkat = ($pers['nama_pangkat'] == $personel_cr['pangkat']) ? 'check.png' : 'warning.png';
							$img_jab = (trim($pers['nama_jabatan']) == trim($jabatan_request['jabatan'])) ? 'check.png' : 'warning.png';
							$img_tmp = (trim($pers['nama_tempat']) == trim($jabatan_request['satker'])) ? 'check.png' : 'warning.png';

						} else {
							$img_nrp = 'cross_circle.png';
							$img_nama = 'cross_circle.png';
							$img_pangkat = 'cross_circle.png';
							$img_jab = 'cross_circle.png';
							$img_tmp = 'cross_circle.png';
						}

						echo"<tr>
							<td>".++$mulai."</td>
							<td>
								NRP: ".$pers['nrp']." <img src='images/".$img_nrp."'><br>
								NAMA: ".$pers['nama']." <img src='images/".$img_nama."'><br>
								Pangkat: ".$pers['nama_pangkat']." <img src='images/".$img_pangkat."'><br>
								Jabatan: ".$pers['nama_jabatan']." <img src='images/".$img_jab."'> ".$idJab."<br>
								Tempat Kerja: ".$pers['nama_tempat']." <img src='images/".$img_tmp."'><br>
							</td>
							<td>
								NRP: ".$personel_cr['nrp']."<br>
								NAMA: ".$personel_cr['nama']."<br>
								Pangkat: ".$personel_cr['pangkat']."<br>
								Jabatan: ".$jabatan_request['jabatan']."<br>
								Tempat Kerja: ".$jabatan_request['satker']."<br>
							</td>
						</tr>";
						
					}
					echo"</tbody>
					</table>";

					//var_dump($personel_arr);
				?>
				</div>

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