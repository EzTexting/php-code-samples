<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh',
);

$curl = curl_init('https://app.eztexting.com/incoming-messages/123?format=json&' . http_build_query($data));
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
    echo 'Status: ' . $json->Status . "\n" .
        'Message ID : ' . $json->Entry->ID . "\n" .
        'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
        'Subject: ' . $json->Entry->Subject . "\n" .
        'Message: ' . $json->Entry->Message . "\n" .
        'New: ' . $json->Entry->New . "\n" .
        'Folder ID: ' . $json->Entry->FolderID . "\n" .
        'Contact ID: ' . $json->Entry->ContactID . "\n" .
        'Received On: ' . $json->Entry->ReceivedOn . "\n\n";
}

?>