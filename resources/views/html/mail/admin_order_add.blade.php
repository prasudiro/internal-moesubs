
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tagihan Pemesanan</title>
<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
<p><strong>Pesanan Baru dari:</strong></p>

{{ $data['fullname']}}<br />
{{ $data['alamat']}}<br /><br />
Nomor HP: {{ $data['hp']}}
<hr>

<p><strong>Detail Pemesanan:</strong></p>
Barang: {{ $produk['shops_product']}}
Jumlah: {{ $data['pesanan']}}
Total : {{ number_format($produk['shops_price']*$data['pesanan'])}} IDR
<hr>

Harap segera ditindaklanjuti di:<br>
<a href="#" target="_blank">https://internal.moesubs.com/Linknya</a>

</body>
</html>
