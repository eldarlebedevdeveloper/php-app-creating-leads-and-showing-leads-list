<?php
$errors = [];
$status = '';
$userIP = getUserIP();
$current_domain = getCurrentDomain();
$token = "ba67df6a-a17c-476f-8e95-bcdb75ed3958";

if (empty($_POST["firstName"])) {
    $errors["firstName"] = "First name is required.";
}

if (empty($_POST["lastName"])) {
    $errors["lastName"] = "Last name is required.";
}

if (empty($_POST["email"])) {
    $errors["email"] = "Email is required";
} elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Invalid email format";
}

if (empty($_POST["phone"])) {
    $errors["phone"] = "Phone is required";
} elseif (!preg_match("/^\+?[0-9\s\-()]+$/", $_POST["phone"])) {
    $errors["phone"] = "Invalid phone number format";
}

if (empty($errors)) {
    $data = array(
        "firstName" => $_POST["firstName"],
        "lastName" => $_POST["lastName"],
        "phone" => $_POST["phone"],
        "email" => $_POST["email"],
        "countryCode" => "RU",
        "box_id" => "28",
        "offer_id" => "3",
        "landingUrl" => $current_domain,
        "ip" => $userIP,
        "password" => "qwerty12",
        "language" => "ru",
        "clickId" => "",
        "quizAnswers" => "",
        "custom1" => "",
        "custom2" => "",
        "custom3" => ""
    );

    $requestParameters = json_encode($data);
    $response = requestAddLead($requestParameters, $token);
    $responseData = json_decode($response, true);

    session_start();
    $_SESSION["status"] = $responseData["status"];
    $_SESSION["responseData"] = $responseData;

    header("Location: index.php");
    exit;
} else {
    session_start();
    $_SESSION["status"] = $status;
    $_SESSION["errors"] = $errors;
    $_SESSION["formData"] = $_POST;
    header("Location: index.php");
    exit;
}

function requestAddLead($requestParameters, $token)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://crm.belmar.pro/api/v1/addlead",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $requestParameters,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "token:" . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function getUserIP()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"]) && filter_var($_SERVER["HTTP_CLIENT_IP"], FILTER_VALIDATE_IP)) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }

    if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ips = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
        foreach ($ips as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    if (!empty($_SERVER["REMOTE_ADDR"]) && filter_var($_SERVER["REMOTE_ADDR"], FILTER_VALIDATE_IP)) {
        return $_SERVER["REMOTE_ADDR"];
    }
    return "Unknown";
}

function getCurrentDomain()
{
    $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https://" : "http://";
    $domainName = $_SERVER["HTTP_HOST"];
    return $protocol . $domainName;
}
