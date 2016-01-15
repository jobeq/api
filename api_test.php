<?php

//Insert your client ID and client secret
$clientID = '';
$clientSecret = '';

$oauthURL = 'http://www.jobeq.net/oauth/access_token';
$grantType = 'client_credentials';

$apiTestURL = 'http://www.jobeq.info/api_test/texts/surveys/iwam/EN';

//Get token
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $oauthURL);

curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt($curl, CURLOPT_USERPWD, $clientID.":".$clientSecret);

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('grant_type' => $grantType));

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec ($curl);
curl_close ($curl);

echo('<p>Token request result: </p>');
echo('<p>'.$result.'</p>');

$tokenData = (array)json_decode($result);

//Send API request with no authorization
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $apiTestURL);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);

//Unauthorized error should be received
echo('<p>API request (no authorization) result: </p>');
echo '<p>'.$result.'</p>';

//Send API request with received token
$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$tokenData['access_token']));
curl_setopt($curl, CURLOPT_URL, $apiTestURL);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);

//Resource should be received
echo('<p>API request result: </p>');
echo ('<p>'.$result.'</p>');


