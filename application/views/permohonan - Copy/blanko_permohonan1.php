<!DOCTYPE html>
<html>
<head>
	<title>Surat Tugas</title>
	<style type="text/css">
		.img-logo{
			height: 100px; 
			width: 100px;
			padding-right: 10px;
		}
		.title-surat{
			text-align: center;
			font-size: 20px;
			font-weight: 600;
			margin-bottom: 30px;
		}
	</style>
</head>
<body>
	<div class="container">
		<table align="center">
			<tr>
				<td width="150" align="right"><img class="img-logo" src="<?= base_url() ?>/assets/image/logo.png"></td>
				<td width="558">
					<center>
						<font size="5" style="font-size: 18px;"><b>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</font><br>
						<font size="5" style="font-size: 18px;">POLITEKNIK NEGERI JEMBER</font><br>
						<font size="5" style="font-size: 18px;">LABORATORIUM ANALISIS PANGAN</font><br>
						<font size="3" style="font-size: 12px;">Jalan Mastrip Kotak Pos 164 Jember 68101</font><br>
						<font size="3" style="font-size: 12px;">Telp. (0331)333532-34. Faxs. (0331)333531. E-mail: lab_analisis@polije.ic.id</b></font><br>
					</center>
				</td>
			</tr>
			<tr>
				<td colspan="2"><hr size="3%" color="black"></td>
			</tr>
		</table> <br><br>
		<div class="title-surat">Surat Keterangan Telah Selesai Melaksanakan Tugas</div>
	</div>
	<table align="center">
		<tr>
			<td colspan="3">Yang bertanda Tangan dibawah Ini :<br><br></td>
		</tr>
		<tr>
			<td width="200">Nama</td>
			<td>:</td>
			<td width="500">{nama_kalab}</td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>:</td>
			<td>{nip_analis}</td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td>{jabatan_analis}</td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td>:</td>
			<td>{unit_analis}</td>
		</tr>
	</table><br>

	<table align="center">
		<tr>
			<td width="720">Telah  melaksanakan pengujian {analisa} dengan butir kegiatan PLP  dibawah  satu jenjang yaitu melakukan pengujian sampel  dengan menggunakan peralatan katagori 2 dan bahan khusus pada kegiatan pengabdian kepada masyarakat ( II.B.39d ).</td>
		</tr>
	</table><br><br>
	<table align="center">
		<tr>
			<td width="300"></td>
			<td width="140"></td>
			<td width="260">Jember, {date}</td>
		</tr>
		<tr>
			<td>Disahkan oleh,</td>
			<td></td>
			<td>Diajukan oleh,</td>
		</tr>
		<tr>
			<td>Kepala</td>
			<td></td>
			<td>PLP. Ahli Muda</td>
		</tr>
		<tr>
			<td>Laboratorium Analisis Pangan</td>
			<td></td>
			<td>Lab.Analisis Pangan</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><br><br><br></td>
		</tr>
		<tr>
			<td>{nama_kalab}</td>
			<td></td>
			<td>{nama_analis}</td>
		</tr>
		<tr>
			<td>NIP. {nip_analis}</td>
			<td></td>
			<td>NIP. {nip_kalab}</td>
		</tr>
	</table>
</body>
</html>