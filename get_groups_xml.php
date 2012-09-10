<?php

$data = array(
    'User'          => 'winnie',
    'Password'      => 'the-pooh',
    'sortBy'        => 'Name',
    'sortDir'       => 'asc',
    'itemsPerPage'  => '10',
    'page'          => '3',
);

$curl = curl_init('https://app.eztexting.com/groups?format=xml&' . http_build_query($data));
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
} elseif (! $xml->Entries->children() ) {
    echo 'Status: ' . $xml->Status . "\n" .
         'Search has returned no groups' . "\n";
} else {
    echo 'Status: ' . $xml->Status . "\n" .
         'Total results: ' . $xml->Entries->children()->count() . "\n\n";

    foreach ( $xml->Entries->children() as $group ) {
        echo 'Group ID : ' . $group->ID . "\n" .
             'Name: ' . $group->Name . "\n" .
             'Note: ' . $group->Note . "\n" .
             'Number of Contacts: ' . $group->ContactCount . "\n\n";
    }
}

?>
                        