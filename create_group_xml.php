<?php

$data = array(
    'User'      => 'winnie',
    'Password'  => 'the-pooh',
    'Name'      => 'Tubby Bears',
    'Note'      => 'A bear, however hard he tries, grows tubby without exercise',
);

$curl = curl_init('https://app.eztexting.com/groups?format=xml');
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
    echo 'Status: ' . $xml->Status . "\n" .
         'Group ID : ' . $xml->Entry->ID . "\n" .
         'Name: ' . $xml->Entry->Name . "\n" .
         'Note: ' . $xml->Entry->Note . "\n" .
         'Number of Contacts: ' . $xml->Entry->ContactCount . "\n";
}

?>
                        