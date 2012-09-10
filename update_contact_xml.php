<?php

$data = array(
    'User'        => 'winnie',
    'Password'    => 'the-pooh',
    'PhoneNumber' => '2123456785',
    'FirstName'   => 'Piglet',
    'LastName'    => 'P.',
    'Email'       => 'piglet@small-animals-alliance.org',
    'Note'        => 'It is hard to be brave, when you are only a Very Small Animal.',
    'Groups'      => array('Friends', 'Neighbors')
);

$curl = curl_init('https://app.eztexting.com/contacts/4f0b5720734fada368000000?format=xml');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
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
         'Groups: ' . implode(', ' , $groups) . "\n" .
         'CreatedAt: ' . $xml->Entry->CreatedAt . "\n";
}

?>
                        