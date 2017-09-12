
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ada Setoran Siap {{ $type=='qc' ? strtoupper($type) : ucfirst($type) }} Baru!</title>
		<style media="all" type="text/css">
		td, p, h1, h3, a {
			font-family: Helvetica, Arial, sans-serif;
		}
		a.bodylink {
			color: #8f98a0;
		}
		a.bodylink:hover {
			color: #ffffff;
		}
		.ds_flag {
			font-size: 10px;
			color: #111111;
			height: 18px;
			line-height: 19px;
			padding: 4px 0 4px 18px;
			white-space: nowrap;
		}
		.ds_flag.ds_wishlist_flag {
			background: url('http://store.edgecast.steamstatic.com/public/images/v6/ds_wishlist.png') no-repeat 4px 4px #d3deea;
			box-shadow: 0 0 6px 0 #000000;
		}
	</style>
</head>
<body bgcolor="" LINK="#6d93b8" ALINK="#9DB7D0" VLINK="#6d93b8" TEXT="#d7d7d7" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #d7d7d7;">
<table style="width: 538px; background-color: #393836;" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td style="background-color: #000000; border-bottom: 1px solid #4d4b48; padding:10px;">
			<h1 align="center" style="margin-bottom:0px;"><span style="color:red">[Moesubs]</span> - <span style="color:#66c0f4">Jagonya Ngesub</span></h1>
		</td>
	</tr>
	<tr>
	<td bgcolor="#17212e">
		<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 5px; padding-right: 5px;">


			<tr bgcolor="#17212e">
				<td style="padding-top: 32px;">
					<span style="font-size: 24px; color: #66c0f4; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
						Halo, {{ $user['name']}}!					</span><br>
					<span style="font-size: 18px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif;">
						Berikut ini adalah setoran baru yang siap di-{{ $type=='qc' ? strtoupper($type) : ucfirst($type) }}:					</span>
				</td>
			</tr>


										<tr>
					<td valign="top" bgcolor="#17212e" style="padding-top: 10px;">
						<span style="font-size: 10px; color: #CCC8BF; font-family: Arial, Helvetica, sans-serif; text-transform: uppercase">
							<a href="http://internal.moesubs.com/setoran/{{ $type}}"><img src="{{ isset($proyek['gambar']) ? $proyek['gambar'] : 'https://puu.sh/xxK7d.png' }}" alt="The Labyrinth of Grisaia" border="0" style="margin: 0; padding: 0;" width="100%"></a>
						</span>
					</td>
				</tr>



				<tr valign="top" bgcolor="17212e" style="margin: 0; padding: 0;">
					<td>
						<table style="background-color: #121a25; width: 100%;">
							<tr>
								<td style="padding-top: 13px; padding-left: 17px; padding-bottom: 2px;">
									<p style="font-size: 20px; color: #e1e1e1; font-family: Arial, Helvetica, sans-serif; margin:0; padding:0;">
										<a href="http://internal.moesubs.com/setoran/{{ $type}}" style="text-decoration:none; color: #ffffff;">
											{{ $kategori['judul']}}	-
											<?php
							          $episode_detail = "Episode";
							          if ($data["setoran_media"] == 1) 
							          {
							          	$episode_detail = "Film Layar Lebar";
							          }
							          elseif ($data["setoran_media"] == 2) 
							          {
							          	$episode_detail = "OVA";
							          }
							          elseif ($data["setoran_media"] == 3) 
							          {
							          	$episode_detail = "SP";
							          }
						          ?>
						          {{ $episode_detail}} {{ $data["setoran_media"] != 1 ? $data["setoran_episode"] < 10 ? "0".$data["setoran_episode"] : $data["setoran_episode"] :  ""}}								</a>
									</p>
																				<p style="color: #7CB8E4; padding: 0; margin: 0; font-size: 12px;">
												Disetor pada {{ date("d M Y - H:i", strtotime($data["created_at"]))}}	WIB										</p>
																																				</td>
							</tr>
						</table>
						<table style="width: 100%" cellpadding="0" cellspacing="0">
							<tr height="14" style="background-color: #121a25; line-height: 14px;">
								<td width="1"></td>
								<td height="14" style="height: 14px; overflow: hidden;">
									&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								</td>
																	<td width="184" height="40" rowspan="3" >
										<table width="100%" style="border-radius: 3px; background-color: #3c3d3e;" cellpadding="0" cellspacing="0">
											<tr>
												<td style="padding: 3px;">
													<table width="100%" height="34" cellpadding="0" cellspacing="0">
														<tr height="34" style="background-color: #000000;">
															<td height="34" width="" style="background-color: #4c6b22; font-size: 16px; line-height: 34px; color: #FFFFFF; text-align: center; white-space: nowrap; overflow: hidden;">
																Penyetor
															</td>
															<td height="34" width="" style="padding-right: 12px; text-align: right; white-space: nowrap; overflow: hidden;">
																<span style="color: #D6D7D8; font-size: 12px;">{{ $user_info['name']}}</span>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
																<td width="12"></td>
								<td width="1"></td>
							</tr>
							<tr height="1">
								<td width="1"></td>
								<td></td>
								<td width="12"></td>
								<td width="1"></td>
							</tr>
							<tr height="25" style="background-color: #17212e;">
								<td width="1"></td>
								<td></td>
								<td width="12"></td>
								<td width="1"></td>
							</tr>

						</table>

					</td>
				</tr>
				<tr>
					<td><br></td>
				</tr>

		</table>
	</td>
	</tr>
	<tr style="background-color: #ffffff;">
		<td style="padding: 12px 24px; border:4px solid #17212e;">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="92">
						<img src="https://puu.sh/xxFXC.png" width="92" alt="Moesubs">
					</td>
					<td style=" font-size: 11px; color: #595959; padding-left: 12px;">
						Copyleft © Moesubs - Anime Fansub Indonesia.<br>
						All wrongs unreserved. <br>Trademarks are property of their respective owners from Japan.					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
