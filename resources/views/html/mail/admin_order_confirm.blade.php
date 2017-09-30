
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tagihan Pemesanan</title>
<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
<h2><b>Berikut data konfirmasi pemesanan yang masuk:</b></h2>
<hr>
<p><strong>Konfirmasi Pembayaran Telah Diterima.</strong></p>
Nama Penyetor: {{ $data['nama_penyetor']}}<br />
Bank: {{ $data['bank_penyetor']}}<br />
Nomor Rekening: {{ $data['norek_penyetor']}}<br />
<b>Dibayar Kepada: {{ $data['tujuan_penyetor']}} </b><br />
Jumlah Pembayaran: {{ number_format($data['jumlah_penyetor'])}} IDR<br />
<hr>

Harap segera ditindaklanjuti di:<br>
<a href="https://internal.moesubs.com/shops" target="_blank">https://internal.moesubs.com/shops</a>

</body>
</html>
