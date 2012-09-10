<?php

$data = array(
    'User'             => 'winnie',
    'Password'         => 'the-pooh',
    'Keyword'          => 'honey',
    'FirstName'        => 'Winnie',
    'LastName'         => 'The Pooh',
    'Street'           => 'Hollow tree, under the name of Mr. Sanders',
    'City'             => 'Hundred Acre Woods',
    'State'            => 'New York',
    'Zip'              => '12345',
    'Country'          => 'US',
    'CreditCardTypeID' => 'Visa',
    'Number'           => '4111111111111111',
    'SecurityCode'     => '123',
    'ExpirationMonth'  => '10',
    'ExpirationYear'   => '2017'
);

$curl = curl_init('https://app.eztexting.com/keywords?format=xml');
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
    foreach( $xml->Entry->ContactGroupIDs->children() as $group ) {
        $groups[] = (string) $group;
    }

    echo 'Status: ' . $xml->Status . "\n" .
         'Keyword ID: ' . $xml->Entry->ID . "\n" .
         'Keyword: ' . $xml->Entry->Keyword . "\n" .
         'Is double opt-in enabled: ' . (int) $xml->Entry->EnableDoubleOptIn . "\n" .
         'Confirm message: ' . $xml->Entry->ConfirmMessage . "\n" .
         'Join message: ' . $xml->Entry->JoinMessage . "\n" .
         'Forward email: ' . $xml->Entry->ForwardEmail . "\n" .
         'Forward url: ' . $xml->Entry->ForwardUrl . "\n" .
         'Groups: ' . implode(', ' , $groups) . "\n";
}

?>
                    