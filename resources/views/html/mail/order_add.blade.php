
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tagihan Pemesanan</title>
<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>

<p><strong>Tagihan Pemesanan {{$produk['shops_product']}}</strong></p>
{{ $data['fullname']}}<br />
{{ $data['alamat']}}<br />
{{ $data['kecamatan']}}, {{ $ongkir['city']}}<br />
{{ $data['provinsi']}} {{ $data['kodepos']}}<br /><br />
Nomor HP: {{ $data['hp']}}
<hr>
<table cellspacing="0" id="invoiceitemstable"><tr><td id="invoiceitemsheading" align="center" width="70%" style="border:1px solid #cccccc;border-bottom:0px;"><strong>Deskripsi</strong></td><td id="invoiceitemsheading" align="center" width="30%" style="border:1px solid #cccccc;border-left:0px;border-bottom:0px;"><strong>Jumlah</strong></td></tr>
<tr bgcolor=#ffffff>
<td id="invoiceitemsrow" style="border:1px solid #cccccc;border-bottom:0px;">&nbsp;&nbsp;Pemesanan {{$produk['shops_product']}} x{{ $data['pesanan']}}&nbsp;&nbsp;</td>
<td align="center" id="invoiceitemsrow" style="border:1px solid #cccccc;border-bottom:0px;border-left:0px;"> {{ number_format($produk['shops_price'])}} IDR</td>
</tr>
<tr bgcolor=#ffffff>
<td id="invoiceitemsrow" style="border:1px solid #cccccc;border-bottom:0px;">&nbsp;&nbsp;Ongkos Kirim via JNE REG&nbsp;&nbsp;</td>
<td align="center" id="invoiceitemsrow" style="border:1px solid #cccccc;border-bottom:0px;border-left:0px;"> {{ number_format($ongkir['cost'])}} IDR</td>
</tr>
<tr><td id="invoiceitemsheading" style="border:1px solid #cccccc;"><div align="right">Total:&nbsp;&nbsp;</div></td><td id="invoiceitemsheading" align="center" style="border:1px solid #cccccc;border-left:0px;"><strong>{{ number_format(($produk['shops_price']*$data['pesanan'])+$ongkir['cost'])}} IDR</strong></td></tr>
</table>
<hr>
<p><strong>Pembayaran</strong></p>

Harap Melakukan Pembayaran ke salah satu rekening di bawah ini:
<p>
{!! $meta_detail['bank']!!}
</p>
<p><strong>CATATAN:</strong> Pembayaran wajib dilakukan sebelum tanggal {{ date("d F Y", strtotime($produk['shops_closed']))}} atau pesanan dibatalkan.</p>
<hr>

<p><strong>Konfirmasi Pembayaran</strong></p>
Setelah melakukan pembayaran ke salah satu rekening di atas, harap melakukan konfirmasi pembayaran di<br>
<a href="{{ URL('order/status/'.base64_encode('userid'.$order_save->shops_detail_id.'userdetailid').'/'.base64_encode($data['email'].'_usermail'))}}" target="_blank">
{{ URL('order/status/'.base64_encode('userid'.$order_save->shops_detail_id.'userdetailid').'/'.base64_encode($data['email'].'_usermail'))}}
</a>
<hr>
<b>PENTING!</b> Tautan di atas sekaligus untuk mengecek status pemesanan Anda, jadi harap disimpan.
</body>
</html>
