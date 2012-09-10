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

$curl = curl_init('https://app.eztexting.com/contacts/4f0b5720734fada368000000?format=json');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// If you experience SSL issues, perhaps due to an outdated SSL cert
// on your own server, try uncommenting the line below
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
curl_close($curl);

$json = json_decode($response);
$json = $json->Response;

if ( 'Failure' == $json->Status ) {
    $errors = array();
    if ( !empty($json->Errors) ) {
        $errors = $json->Errors;
    }

    echo 'Status: ' . $json->Status . "\n" .
         'Errors: ' . implode(', ' , $errors) . "\n";
} else {
    $groups = array();
    if ( !empty($json->Entry->Groups) ) {
        $groups = $json->Entry->Groups;
    }

    echo 'Status: ' . $json->Status . "\n" .
         'Contact ID : ' . $json->Entry->ID . "\n" .
         'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
         'First Name: ' . $json->Entry->FirstName . "\n" .
         'Last Name: ' . $json->Entry->LastName . "\n" .
         'Email: ' . $json->Entry->Email . "\n" .
         'Note: ' . $json->Entry->Note . "\n" .
         'Source: ' . $json->Entry->Source . "\n" .
         'Groups: ' . implode(', ' , $groups) . "\n" .
         'CreatedAt: ' . $json->Entry->CreatedAt . "\n";
}

?>
                        