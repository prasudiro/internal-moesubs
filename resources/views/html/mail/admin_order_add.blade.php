
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
{{ $data['alamat']}}<br />
{{ $data['kecamatan']}}, {{ $ongkir['city']}}<br />
{{ $data['provinsi']}} {{ $data['kodepos']}}<br />
Nomor HP: {{ $data['hp']}}
<hr>

<p><strong>Detail Pemesanan:</strong></p>
Barang: {{ $produk['shops_product']}}<br>
Jumlah: {{ $data['pesanan']}}<br>
Total : {{ number_format(($produk['shops_price']*$data['pesanan'])+$ongkir['cost'])}} IDR (Sudah termasuk ongkos kirim)<br>
<hr>

Harap segera ditindaklanjuti di:<br>
<a href="https://internal.moesubs.com/shops" target="_blank">https://internal.moesubs.com/shops</a>

</body>
</html>
