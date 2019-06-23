<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<form action="index.php" method="post" enctype="multipart/form-data">
<label for="">Nama : </label>
	<input type="text" name="nama" id=""><br>
	<label for="">kelas</label>
	<input type="text" name="kelas" id=""><br>
	<label for="">Jurusan :</label>
	<input type="text" name="jurusan" id="">
	<button type="submit" name="kirim">Submit</button>
	<button type="submit" name="load">Load Data</button>
	</form>
</body>
</html>
<?php 
	$host ="riyanwar.database.windows.net";
	$user = "riyanwar";
	$pass = "Nurlaela0902";
	$db = "myDB";

	try {
		$conn = new PDO("sqlsrv:server = tcp:riyanwar.database.windows.net,1433; Database = myDB", "riyanwar", "{Nurlaela0902}");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		print("Error connecting to SQL Server.");
		die(print_r($e));
	}

	if(isset($_POST['kirim'])){
		try {
			$nama = $_POST['nama'];
			$kelas = $_POST['kelas'];
			$jurusan = $_POST['jurusan'];
			$date = date("Y-m-d");

			$sql = "INSERT INTO Mahasiswa(nama,kelas,jurusan,date) VALUES(?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(1, $nama);
			$stmt->bindValue(2, $kelas);
			$stmt->bindValue(3, $jurusan);
			$stmt->bindValue(4, $date);
			
		} catch (Exception $e) {
			echo "Failed:",$e;
		}
		echo "<<br>Berhasil Terdaftar";
	}else if (isset($_POST['load'])) {
		try {
			$ambil = "SELECT * FROM Mahasiswa";
			$stmt = $conn->query($ambil);
			$tampil = $stmt->fetchAll();
			if (count($tampil)>0) {
				echo "<table>";
				echo "<tr>";
				echo "<td>Nama</td>";
				echo "<td>Kelas</td>";
				echo "<td>Jurusan</td>";
				echo "<td>Tanggal</td>";
				echo "</tr>";
				foreach ($tampil as $t) {
					
				echo "<tr>";
				echo "<td>".$t['nama']."</td>";
				echo "<td>".$t['kelas']."</td>";
				echo "<td>".$t['jurusan']."</td>";
				echo "<td>".$t['date']."</td>";
				echo "</tr>";
				}
				echo "</table>";
			}else {
				echo "Data Unknown";
			}
		} catch (Exception $e) {
			echo "Failed: ".$e;
		}
	}

?>