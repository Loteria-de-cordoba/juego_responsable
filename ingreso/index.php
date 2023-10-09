<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);


$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://dev-gwxtj8f3wl4qq831.us.auth0.com/oauth/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"client_id\":\"FXy5jG2QnDOu1B1uZU0lLFltHvnHF7nC\",\"client_secret\":\"s3rk2f1zjsd8hiI6rmkl6VYnPLi-trY4ZL53dX9WY5YYf9hfUSZkwT1jhRM1ydb2\",\"audience\":\"https://jolapi.loteriacba.com.ar/gamblers/\",\"grant_type\":\"client_credentials\"}",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
// die(var_dump($response));
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //die(var_dump($response));
  echo json_decode($response);
}

die(var_dump($response));
$array = json_decode($response);

$token = $array->{'token_type'} . ' ' . $array->{'access_token'};

// Response
// {
//     "access_token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IklaUlozUTUzSWxNc2xkNHJ5dkkyaCJ9.eyJpc3MiOiJodHRwczovL2Rldi1nd3h0ajhmM3dsNHFxODMxLnVzLmF1dGgwLmNvbS8iLCJzdWIiOiJGWHk1akcyUW5ET3UxQjF1WlUwbExGbHRIdm5IRjduQ0BjbGllbnRzIiwiYXVkIjoiaHR0cHM6Ly9qb2xhcGkubG90ZXJpYWNiYS5jb20uYXIvZ2FtYmxlcnMvIiwiaWF0IjoxNjk2NzAxMDY4LCJleHAiOjE2OTY3ODc0NjgsImF6cCI6IkZYeTVqRzJRbkRPdTFCMXVaVTBsTEZsdEh2bkhGN25DIiwiZ3R5IjoiY2xpZW50LWNyZWRlbnRpYWxzIn0.KI26xAHAEq0jIejirvJQGxBcpQ9AhADFzImteIT-B8o5QZjqvcRQ7btD4mJpKckV8YECxl3xnj9Ybp8liwmoCWq71D75yHF04KuU8xsYt1f-LTvFeapmIljfmtYGBy0ycKieXOqC3JZupBm4OL5zFR0zAR8bMJV6tyZQ-oXJs5193t1fLmM5792lJvHMYMazUmu3YS2KBbZFQvE9U-O3Rh0IsFXS6EwqBEvbSIlrfptGhmtdGXBtZnK-vlllFPhaWU_O6eR1W3ubHQGU9CrYMmtX-e8kh4M2DGAHm8bSZ_oUdMlFy7cPDm4TQHldbbYv4mJT2vS-z9wd3yk1B9cXJw",
//     "token_type": "Bearer"
// }

// die();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://homolog.loteriacba.com.ar/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ 
                            'documentType': 'DNI', 
                            'documentNumber': '21400329', 
                            'gender': 'M', 
                            'dob': '1969-12-29' 
                          }",
  CURLOPT_HTTPHEADER => array(
    "authorization: " . $token
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>