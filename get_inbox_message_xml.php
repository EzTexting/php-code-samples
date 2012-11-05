<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh',
);

$curl = curl_init('https://app.eztexting.com/incoming-messages/123?format=xml&' . http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);

$xml = new SimpleXMLElement($response);
if ('Failure' == $xml->Status) {
    $errors = array();
    foreach ($xml->Errors->children() as $error) {
        $errors[] = (string)$error;
    }

    echo 'Status: ' . $xml->Status . "\n" .
        'Errors: ' . implode(', ', $errors) . "\n";
}
else {
    echo 'Status: ' . $xml->Status . "\n" .
        'Message ID : ' . $xml->Entry->ID . "\n" .
        'Phone Number: ' . $xml->Entry->PhoneNumber . "\n" .
        'Subject: ' . $xml->Entry->Subject . "\n" .
        'Message: ' . $xml->Entry->Message . "\n" .
        'New: ' . $xml->Entry->New . "\n" .
        'Folder ID: ' . $xml->Entry->FolderID . "\n" .
        'Contact ID: ' . $xml->Entry->ContactID . "\n" .
        'Received On: ' . $xml->Entry->ReceivedOn . "\n\n";
}

?>