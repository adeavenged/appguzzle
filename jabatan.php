<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Update Data Personel</title>


    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
</head>
<body>

	<?php
		require 'function_update.php';

		$totalpersonel = total_personel_cat();
		
		$per_page = 1000;
		$jumlahHalaman = ceil($totalpersonel/$per_page);
		
		$page = isset($_GET['start']) ? (int)$_GET["start"] : 0;
		$mulai = ($page>1) ? ($page - 1) * $per_page : 0;

		$data_all='';
		$jmldata = 0;
		if (isset($_GET['start'])) {
			$data_all = data_all_personel_perpage($mulai, $per_page);

			$jmldata = count($data_all);
		}
		
	?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-5">
				<h2>Update Data Jabatan</h2>
				<p>Jumlah Data : <?= $jmldata; ?></p>
				<form action="" method="get" onchange="submit()">
					<div class="form-group">
	    			<label for="halaman">Select Halaman</label>
						<select name="start" class="form-control mb-2" id="halaman">
							<?php
								for($i=1;$i <= $jumlahHalaman; $i++) {
									if($page == $i) {
										echo'<option value="'.$i.'" selected>- Halaman '.$i.' -</option>';	
									} else {
										echo'<option value="'.$i.'">- Halaman '.$i.' -</option>';	
									}
									
								}
							?>
						</select>
						<button type="button" id="prosesupdate" class="btn btn-primary">
							<span class="spinner-grow spinner-grow-sm" role="status" id="btnload" aria-hidden="true"></span>
	  					Proses Update
						</button>
					</div>
				</form>
				<div class="d-flex align-items-center mb-2">
					<strong id="det">Loading...</strong>
					<div class="spinner-border text-primary ml-auto" id="loaddata" role="status"></div>
				</div>

				<div class="progress mb-3">
				  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>

				<hr>

				<ul id="permessage" style="height: 200px;overflow-y: scroll;"></ul>

				

			</div>

			<div class="col-lg-3">
				<ul id="proerror" style="height: 300px;overflow-y: scroll;"></ul>
			</div>

		</div>
	</div>
			

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<script type="text/javascript">
			$(function() {
				$('#loaddata').hide();
				$('#btnload').hide();


				$("#prosesupdate").click(function() {
					$('#loaddata').show();
					$('#btnload').show();
					$(this).attr('disabled','disabled');

					var no = 0;
					var perc = 0;
					var dataku = {'personel': <?= json_encode($data_all); ?>};

					$.each(dataku.personel, function(i, pers) {
						// console.log(pers);
						// 

						$.ajax({
	            url: "prosesjab.php",
	            method: "POST",
	            data: {'personel': pers},
	            dataType: 'json',
	            success: function(data) {
	            	// console.log(data);
	                

	                $("#det").text('Processing : '+pers.nama);
	                
	                _loader();

	                

	                $('#permessage').prepend('<li>'+no+'. <span class="'+data.color+'">'+data.nama+'</span> ('+ data.message +')</li>');

	                // setTimeout(5000);

	                //$("#loading").hide();

	            },

	            error: function(jqXHR, textStatus, errorThrown) {

	                _loader();

	                $('#proerror').append('<li>'+no+'. '+pers.nrp+' - '+pers.nama+' (<i class="text-danger">'+textStatus+' *'+errorThrown+'</i>)</li>');

	                // console.log('ERROR', textStatus, errorThrown);

	            }

	          });

						function _loader()
						{
							no++;
							perc = (no*100)/<?= $jmldata; ?>;
							$('.progress-bar').css('width', perc.toFixed(2)+'%');
              $('.progress-bar').attr('aria-valuenow').value = perc.toFixed(2);
              $('.progress-bar').text(perc.toFixed(2)+'%');

              if(perc >= 100) {
                  // $(".progress-bar").removeClass("progress-bar-warning");
                  // $(".progress-bar").addClass("progress-bar-success");
                  $("#prosesupdate").text('Finish');
                  $('#loaddata').hide();
									$('#btnload').hide();

              }
						}

					});

					
				});

			});
				
		</script>
</body>
</html>


	