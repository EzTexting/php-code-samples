<?php

$data = array(
    'User'          => 'winnie',
    'Password'      => 'the-pooh',
    'source'        => 'upload',
    'optout'        => false,
    'group'         => 'Honey Lovers',
    'sortBy'        => 'PhoneNumber',
    'sortDir'       => 'asc',
    'itemsPerPage'  => '10',
    'page'          => '3',
);

$curl = curl_init('https://app.eztexting.com/contacts?format=xml&' . http_build_query($data));
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
         'Search has returned no results' . "\n";
} else {
    echo 'Status: ' . $xml->Status . "\n" .
         'Total results: ' . $xml->Entries->children()->count() . "\n\n";

    foreach ( $xml->Entries->children() as $contact ) {
        $groups = array();
        foreach( $contact->Groups->children() as $group ) {
            $groups[] = (string) $group;
        }

        echo 'Contact ID : ' . $contact->ID . "\n" .
             'Phone Number: ' . $contact->PhoneNumber . "\n" .
             'First Name: ' . $contact->FirstName . "\n" .
             'Last Name: ' . $contact->LastName . "\n" .
             'Email: ' . $contact->Email . "\n" .
             'Note: ' . $contact->Note . "\n" .
             'Source: ' . $contact->Source . "\n" .
             'Opted Out: ' . ($contact->OptOut ? 'true' : 'false') . "\n" .
             'Groups: ' . implode(', ' , $groups) . "\n" .
             'CreatedAt: ' . $contact->CreatedAt . "\n\n";
    }
}

?>
                        