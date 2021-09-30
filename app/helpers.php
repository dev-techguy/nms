<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\Log;

function sendSms($phone, $message)
{
    //Format phone
    $mobile = formatPhone($phone, "254");

    $userID = 1818;
    $token = md5('brighton2020');
    $timestamp = date('YmdHis');
    $senderId = "BRIGHTONLTD";

    //URL of targeted site
    $url = "http://api.bizsms.co.ke/submit2.php";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "AuthDetails": [
                {
                    "UserID": "' . $userID . '",
                    "Token": "' . $token . '",
                    "Timestamp": "' . $timestamp . '"
                }
            ],
            "SubAccountID": [
                "0"
            ],
            "MessageType": [
                "2"
            ],
            "BatchType": [
                "0"
            ],
            "SourceAddr": [
                "' . $senderId . '"
            ],
            "MessagePayload": [
                {
                    "Text": "' . $message . '"
                }
            ],
            "DestinationAddr": [
                {
                    "MSISDN": "' . $mobile . '",
                    "LinkID": "",
                    "SourceID": "2"
                }
            ]
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    Log::info($message);

    $decoded_response = json_decode($response);
    //dd($decoded_response);
    if ($decoded_response && is_array($decoded_response)) {
        $res = reset($decoded_response);

        if ($res->ResponseCode == '1001')
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function formatPhone($phone, $prefix = 0)
{
    $phone_1 = str_replace("-", "", $phone);
    $phone_2 = str_replace(" ", "", $phone_1);
    $formattedphone = $prefix . substr($phone_2, -9);

    return $formattedphone;
}

function regSlug($reg)
{
    $reg_1 = str_replace("-", "", $reg);
    $reg_2 = str_replace(" ", "", $reg_1);
    $sluggiffiedreg = strtolower($reg_2);

    return $sluggiffiedreg;
}
