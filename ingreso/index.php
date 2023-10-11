<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Origin: https://gray-mud-0c8914110.azurestaticapps.net");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}


// $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IklaUlozUTUzSWxNc2xkNHJ5dkkyaCJ9.eyJpc3MiOiJodHRwczovL2Rldi1nd3h0ajhmM3dsNHFxODMxLnVzLmF1dGgwLmNvbS8iLCJzdWIiOiJGWHk1akcyUW5ET3UxQjF1WlUwbExGbHRIdm5IRjduQ0BjbGllbnRzIiwiYXVkIjoiaHR0cHM6Ly9qb2xhcGkubG90ZXJpYWNiYS5jb20uYXIvZ2FtYmxlcnMvIiwiaWF0IjoxNjk2ODYxMzMwLCJleHAiOjE2OTY5NDc3MzAsImF6cCI6IkZYeTVqRzJRbkRPdTFCMXVaVTBsTEZsdEh2bkhGN25DIiwiZ3R5IjoiY2xpZW50LWNyZWRlbnRpYWxzIn0.ckZp7wPZRXoibJs4jZQ7m7iNgC80HLi5lTh6QInQw23mexY0OW0i9Igu_ZpoFQgUiZ41hWRJrMxioMBthNS7s56fmOxz9aZ1l1LuGGEFGqArLBQ_NLfog029thNCsRq1RwmhqQclNIqnfcJGO2Ptx2EnEYjxlVjQQHnJ7LFGlDN1FHSP3hwvzbOd17FhcfbVk1S7sQGTyoBoaMbD56X0YC9G71CBnPfHczrJfkQoCBH-iLj5r_1EzlottDF5cgEdfty_PsJrV--eKYJ_AFoBoRG1i_V4jvM6lOSEGMbe0hgodJZHjwg9wbXaNHSE02v9QMieJjg54MufHNeWxySBYg";


$token = obtenerToken();
$data = obtenerDatos($token);

$result =  json_decode($data, true);

// die(var_dump($data));

// if ($result['statusCode']==401) {
//   $token = generarToken();
//   $data = obtenerDatos($token);
// }

header('Content-type: text/json');
header('Content-type: application/json');

die(json_encode($data));

function obtenerDatos($token) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://homolog.loteriacba.com.ar/validated/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"documentType\": \"DNI\",\"documentNumber\": \"21400329\",\"gender\": \"M\",\"dob\": \"1969-12-29\"}",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . $token,
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $response = $err;
    }

    return $response;

}

function generarToken() {

    $curl = curl_init();

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
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $response = $err;
        header('Content-type: text/json');
        header('Content-type: application/json');
        die(json_encode($response));
    }

    $array = json_decode($response, true);
    $token = $array['access_token'];

    $file = 'token.txt';
    // // Write the contents back to the file
    file_put_contents($file, $token);
    
    return $token;
}

function obtenerToken() {
    $file = 'token.txt';
    // Open the file to get existing content
    return file_get_contents($file);
}
