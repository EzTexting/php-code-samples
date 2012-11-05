<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh',
    'sortBy' => 'PhoneNumber',
    'sortDir' => 'asc',
    'itemsPerPage' => '10',
    'page' => '3',
);

$curl = curl_init('https://app.eztexting.com/incoming-messages?format=xml&' . http_build_query($data));
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
elseif (!$xml->Entries->children()) {
    echo 'Status: ' . $xml->Status . "\n" .
        'Search has returned no results' . "\n";
}
else {
    echo 'Status: ' . $xml->Status . "\n" .
        'Total results: ' . $xml->Entries->children()->count() . "\n\n";

    foreach ($xml->Entries->children() as $message) {
        echo 'Message ID : ' . $message->ID . "\n" .
            'Phone Number: ' . $message->PhoneNumber . "\n" .
            'Subject: ' . $message->Subject . "\n" .
            'Message: ' . $message->Message . "\n" .
            'New: ' . $message->New . "\n" .
            'Folder ID: ' . $message->FolderID . "\n" .
            'Contact ID: ' . $message->ContactID . "\n" .
            'Received On: ' . $message->ReceivedOn . "\n\n";
    }
}

?>