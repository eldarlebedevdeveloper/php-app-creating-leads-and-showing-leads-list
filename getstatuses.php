<?php
$startDate = !empty($_POST["startDate"]) ? $_POST["startDate"] . " " . "00:00:00" : "";
$endDate = !empty($_POST["endDate"]) ? $_POST["endDate"] . " " . "23:59:59" : "";
$token = "ba67df6a-a17c-476f-8e95-bcdb75ed3958";
$data = array(
  "date_from" => $startDate,
  "date_to" => $endDate,
  "page" => 0,
  "limit" => 100,
);

$requestParameters = json_encode($data);
$response = getStatuses($requestParameters, $token);
$responseData = json_decode($response, true);

if ($responseData["status"] === true) {
  session_start();
  $_SESSION["leads"] = $responseData['data'];

  header("Location: ./leads.php");
  exit;
} else {
  session_start();
  $error = $responseData['error'];
  $_SESSION["leadsError"] = $responseData['error'];

  header("Location: ./leads.php");
  exit;
}

function getStatuses($requestParameters, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://crm.belmar.pro/api/v1/getstatuses',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $requestParameters,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      "token:" . $token
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}
