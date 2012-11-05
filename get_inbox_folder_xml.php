<?php

$data = array(
    'User' => 'winnie',
    'Password' => 'the-pooh'
);

$curl = curl_init('https://app.eztexting.com/messages-folders/123?format=xml&' . http_build_query($data));
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
        'Folder Name: ' . $xml->Entry->Name . "\n";
}

?>