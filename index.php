<?php
	//  Buat fungsi bernama total_rupiah untuk menghitung nilai rupiah hasil penukaran valas 
	//	sesuai INSTRUKSI KERJA 7.

      function total_rupiah($jumlah,$valas){
				$totalRupiah = $jumlah * $valas;
				return $totalRupiah;
      }



	//  Buat sebuah array satu dimensi yang berisi beberapa valuta asing (valas) sesuai INSTRUKSI KERJA 1
	$valas = array("US Dollar", "Singapore Dollar", "Pound Sterling", "Japan Yen", "South Korea Won", "Chinese Yuan"); 
	//  dan urutkan array secara descending sesuai INSTURKSI KERJA 2.
	rsort($valas);
      
	


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Money Changer Amanah</title>
		<!-- Hubungkan halaman web dengan file library CSS yang sudah tersedia -->
		<!-- sesuai INSTRUKSI KERJA 4. -->
			<link rel="stylesheet" href="assets/css/bootstrap.css">
		

	</head>
	
	<body>
	<div class="container border my-3">
		<div class="d-flex">
			<!-- Menampilkan judul halaman -->
			<h1>Money Changer Amanah</h1>
			
			<!-- Tampilkan logo sesuai INSTRUKSI KERJA 5. -->
				<img style="width: 40px; height:40px;" class="ml-3" src="assets/img/money-logo.png" alt="logo">
		</div>

		
		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formMoneyChanger">
			<div class="row">
				<!-- Masukan nama pemesan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pemesan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan NIK pemesan. Tipe data text. -->
			 	<!-- Modifikasi input supaya NIK yang dimasukkan harus tepat 16 karakter sesuai INSTRUKSI KERJA 6. -->

				<div class="col-lg-2"><label for="nik">NIK:</label></div>
				<div class="col-lg-2"><input type="text" id="nik" name="nik"></div> 
				<!--Type berubah menjadi text karena NIK bukan Number -->

			</div>
			<div class="row">
				<!-- Masukan pilihan valuta asing. -->
				<div class="col-lg-2"><label for="valas">Valuta asing:</label></div>
				<div class="col-lg-2">
					<select id="valas" name="valas">
					<option value="">- Pilih valas -</option>

					<!-- Tampilkan dropdown valas berdasarkan data pada array valas menggunakan perulangan -->
					<!-- sesuai INSTRUKSI KERJA 3. -->
					<?php for ($i = 0; $i < count($valas); $i++) { ?>
						<option value="<?php echo $valas[$i] ?>"><?php echo $valas[$i] ?></option>
					<?php } ?>



					</select>
				</div>
			</div>
			<div class="row">
				<!-- Masukan jumlah valas. Tipe data number. -->
				<div class="col-lg-2"><label for="jumlah">Jumlah valas:</label></div>
				<div class="col-lg-2"><input type="number" id="jumlah" name="jumlah" maxlength="4"></div>
			</div>
			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formMoneyChanger" value="Hitung" name="Hitung" id="submit">Hitung</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
	<?php
		//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
		if(isset($_POST['Hitung'])) {
			
			//array $dataKonversiValas
			$dataKonversiValas = array(
				'nama' => $_POST['nama'],
				'nik' => $_POST['nik'],
				'valas' => $_POST['valas'],
				'jumlah' => $_POST['jumlah']
			);

		//	Simpan data pemesanan valas dari array $dataKonversiValas ke dalam file JSON/TXT/Excel/database sesuai INSTRUKSI KERJA 11.
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
			// Baca file JSON yang sudah ada
			$json = file_get_contents("assets/data/data.json");

			// Decode file JSON menjadi array
			$dataKonversiValas = json_decode($json, true);

			// Tambahkan data yang baru
			$dataKonversiValas = array(
				'nama' => $_POST['nama'],
				'nik' => $_POST['nik'],
				'valas' => $_POST['valas'],
				'jumlah' => $_POST['jumlah']
			);

			// Encode array menjadi format JSON
			$json = json_encode($dataKonversiValas, JSON_PRETTY_PRINT);

			// Tulis kembali file JSON dengan data yang baru
			file_put_contents("assets/data/data.json", $json);
		}



		// $dataJson = json_encode();
		// file_put_contents();
		// $dataJson = file_get_contents();
		// $dataKonversiValas = json_decode();


		//	Simpan jumlah valas yang sudah diinputkan pada form ke dalam variabel $jumlah sesuai INSTRUKSI KERJA 8
			$jumlah = $dataKonversiValas['jumlah'];


		//	Variabel $nilaiValas menyimpan nilai valas berdasarkan jenis valas yang dipilih.
		//	Gunakan pencabangan untuk menentukan nilai variabel $nilaiValas berdasarkan INSTRUKSI KERJA 9.
		if($dataKonversiValas['valas'] == "US Dollar") {
			$nilaiValas = 15000;
		} else if ($dataKonversiValas['valas'] == "Singapore Dollar"){
			$nilaiValas = 11000;
		} else if ($dataKonversiValas['valas'] == "Pound Sterling"){
			$nilaiValas = 18.500;
		} else if ($dataKonversiValas['valas'] == "Japan Yen") {
			$nilaiValas = 110;
		} elseif($dataKonversiValas['valas'] == "South Korea Won") {
			$nilaiValas = 11;
		} else {
			$nilaiValas = 2200;
		}




		//	Variabel $totalRupiah menyimpan nilai konversi valas ke dalam Rupiah.
		//	Gunakan fungsi yang sudah dibuat dalam Instruksi Kerja 7 untuk menghitung nilai $totalRupiah sesuai INSTRUKSI KERJA 10.
			$totalRupiah = total_rupiah($jumlah, $nilaiValas);

		//	Tampilkan data pemesanan dan hasil perhitungan konversi valas.
			echo "<br/>
				<div class='container'>
					<div class='row'>
						<!-- Menampilkan nama pemesan. -->
						<div class='col-lg-2'>Nama pemesan:</div>
						<div class='col-lg-2'>".$dataKonversiValas['nama']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan NIK pemesan. -->
						<div class='col-lg-2'>NIK:</div>
						<div class='col-lg-2'>".$dataKonversiValas['nik']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan valas yang dikonversi. -->
						<div class='col-lg-2'>Valas:</div>
						<div class='col-lg-2'>".$dataKonversiValas['valas']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan jumlah valas. -->
						<div class='col-lg-2'>Jumlah valas:</div>
						<div class='col-lg-2'>".$dataKonversiValas['jumlah']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan hasil konversi. -->
						<div class='col-lg-2'>Total Rupiah:</div>
						<div class='col-lg-2'>Rp".number_format($totalRupiah, 0, ".", ".").",-</div>
					</div>
			</div>
			";
		}
	?>
	<script>
		const cekNik = document.getElementById("submit");
		const inputNik = document.getElementById("nik");
		cekNik.addEventListener('click', () => {
			if(inputNik.value.length < 16) {
				alert("nik yang anda masukan kurang");
			} else if (inputNik.value.length > 16) {
				alert("nik yang anda masukan lebih dari 16 digit");
			}
		})
	</script>
	</body>
</html>