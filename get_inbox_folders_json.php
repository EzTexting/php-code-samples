<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh'
);

$curl = curl_init('https://app.eztexting.com/messages-folders?format=json&' . http_build_query($data));
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
elseif (empty($json->Entries)) {
    echo 'Status: ' . $json->Status . "\n" .
        'Search has returned no results' . "\n";
}
else {
    echo 'Status: ' . $json->Status . "\n" .
        'Total results: ' . count($json->Entries) . "\n\n";

    foreach ($json->Entries as $folder) {
        echo 'ID : ' . $folder->ID . "\n" .
            'Name: ' . $folder->Name . "\n\n";
    }
}

?>