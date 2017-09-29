<?php 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  // CURLOPT_POSTFIELDS => "origin=bandung&destination=jakarta&weight=1000&courier=jne",
  CURLOPT_HTTPHEADER => array(
    // "content-type: application/x-www-form-urlencoded",
    "key: 57fb1f3af1513838e1e9dbeb15920a56"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$hasil = json_decode($response, TRUE);

print"<pre>";
print_r($hasil['rajaongkir']['results']);
exit();

$city = Array(
							Array
							(
								'city_id' => '1',
                'province_id' => '21',
                'province' => 'Nanggroe Aceh Darussalam (NAD)',
                'type' => 'Kabupaten',
                'city_name' => 'Aceh Barat',
                'postal_code' => '23681',
              )
             );

print"<pre>";print_r($city);exit();
?>