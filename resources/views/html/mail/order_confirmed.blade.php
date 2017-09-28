
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pesanan Dikonfirmasi</title>
<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>

<h1><strong>LUNAS</strong></h1>
<hr>

<p><strong>Konfirmasi Pembayaran Telah Sukses Dilunasi.</strong></p>
Nama Penyetor: {{ $meta_detail['nama_penyetor']}}<br />
Bank: {{ $meta_detail['bank_penyetor']}}<br />
Nomor Rekening: {{ $meta_detail['norek_penyetor']}}<br />
<b>Dibayar Kepada: {{ $meta_detail['tujuan_penyetor']}} </b><br />
Jumlah Pembayaran: {{ number_format($meta_detail['jumlah_penyetor'])}} IDR<br />

<hr>

<p><strong>Detail Pemesanan:</strong></p>
Barang: {{ $product['shops_product']}}<br>
Harga: {{ number_format($product['shops_price'])}} IDR<br>
Jumlah: {{ $shops_detail['shops_detail_quantity']}}<br>
Total : {{ number_format($product['shops_price']*$shops_detail['shops_detail_quantity'])}} IDR<br>

<hr>

<p><strong>Periksa Status Pemesanan</strong></p>
Setelah lunas harap lakukan pengecekan resi secara berkala di:<br>
<a href="{{ URL('order/status/'.base64_encode('userid'.$shops_detail["shops_detail_id"].'userdetailid').'/'.base64_encode($shops_detail['shops_detail_email'].'_usermail'))}}" target="_blank">
{{ URL('order/status/'.base64_encode('userid'.$shops_detail['shops_detail_id'].'userdetailid').'/'.base64_encode($shops_detail['shops_detail_email'].'_usermail'))}}
</a>
<hr>
<b>PENTING!</b> Tautan di atas sekaligus untuk mengecek status pemesanan Anda, jadi harap disimpan.

</body>
</html>
