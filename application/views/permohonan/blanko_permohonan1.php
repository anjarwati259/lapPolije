<!DOCTYPE html>
<html>
<head>
	<title>Kwitansi</title>
	<style type="text/css">
		.img-logo{
			height: 100px; 
			width: 100px;
			padding-right: 10px;
		}
		.title-surat{
			text-align: center;
			font-size: 25px;
			font-weight: 500;
		}
		.nomor-surat{
			text-align: center; 
			margin-top: 5px;
			margin-bottom: 20px;
			font-size: 18px;
		}
		#customers {
		  border-collapse: collapse;
		}

		#customers td, #customers th {
		  border: 2px solid #504e4e;
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
		<div class="title-surat">Kwitansi</div>
		<div class="nomor-surat" style="">(No. {nomor_kwitansi})</div>
	</div><br>

	<table align="center" style="border-spacing: 15px;">
		<tr>
			<td width="200">Telah diterima dari</td>
			<td>:</td>
			<td width="470">{nama_customer}</td>
		</tr>
		<tr>
			<td>Uang sejumlah</td>
			<td></td>
			<td height="50" style="border: solid 3px; text-align: center; font-size: 25px; font-weight: 700;">{terbilang}</td>
		</tr>
		<tr>
			<td>Untuk pembayaran</td>
			<td>:</td>
			<td> Analisa {jenis_analisa} sebanyak {jml_sample} sampel (No. {kode_sample})</td>
		</tr>
		<tr>
			<td>Terbilang</td>
			<td>:</td>
			<td> <u>Rp. {total}</u></td>
		</tr>
	</table><br>

	<table align="center">
		<tr>
			<td width="420"></td>
			<td width="300">Jember, {date}</td>
		</tr>
		<tr>
			<td></td>
			<td>Kepala Laboratorium Analisis Pangan</td>
		</tr>
		<tr>
			<td></td>
			<td><br><br><br></td>
		</tr>
		<tr>
			<td></td>
			<td>{nama_kalab}</td>
		</tr>
		<tr>
			<td></td>
			<td>NIP. {nip_kalab}</td>
		</tr>
		<tr>
			<td colspan="3"><br><br><i>Catatan:<br>*Total biaya tidak termasuk PPN dan PPh</i></td>
		</tr>
	</table>
</body>
</html>