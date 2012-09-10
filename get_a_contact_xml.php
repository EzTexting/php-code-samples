<?php

$data = array(
    'User'     => 'winnie',
    'Password' => 'the-pooh',
);

$curl = curl_init('https://app.eztexting.com/contacts/4f0b52fd734fada068000000?format=xml&' . http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// If you experience SSL issues, perhaps due to an outdated SSL cert
// on your own server, try uncommenting the line below
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
curl_close($curl);

$xml = new SimpleXMLElement($response);
if ( 'Failure' == $xml->Status ) {
    $errors = array();
    foreach( $xml->Errors->children() as $error ) {
        $errors[] = (string) $error;
    }

    echo 'Status: ' . $xml->Status . "\n" .
         'Errors: ' . implode(', ' , $errors) . "\n";
} else {
    $groups = array();
    foreach( $xml->Entry->Groups->children() as $group ) {
        $groups[] = (string) $group;
    }

    echo 'Status: ' . $xml->Status . "\n" .
         'Contact ID : ' . $xml->Entry->ID . "\n" .
         'Phone Number: ' . $xml->Entry->PhoneNumber . "\n" .
         'First Name: ' . $xml->Entry->FirstName . "\n" .
         'Last Name: ' . $xml->Entry->LastName . "\n" .
         'Email: ' . $xml->Entry->Email . "\n" .
         'Note: ' . $xml->Entry->Note . "\n" .
         'Source: ' . $xml->Entry->Source . "\n" .
         'Opted Out: ' . ($xml->Entry->OptOut ? 'true' : 'false') . "\n" .
         'Groups: ' . implode(', ' , $groups) . "\n" .
         'CreatedAt: ' . $xml->Entry->CreatedAt . "\n";
}

?>
                        