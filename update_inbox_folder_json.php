<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh',
    'Name' => 'Customers'
);

$curl = curl_init('https://app.eztexting.com/messages-folders/123?format=json');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);

$json = json_decode($response);
$json = $json->Response;

if ('Failure' == $json->Status) {
    $errors = array();
    if (!empty($json->Errors)) {
        $errors = $json->Errors;
    }

    echo 'Status: ' . $json->Status . "\n" .
        'Errors: ' . implode(', ', $errors) . "\n";
}
else {
    echo 'Status: ' . $json->Status . "\n";
}

?>