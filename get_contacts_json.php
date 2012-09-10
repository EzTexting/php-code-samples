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

$curl = curl_init('https://app.eztexting.com/contacts?format=json&' . http_build_query($data));
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
} elseif ( empty($json->Entries) ) {
    echo 'Status: ' . $json->Status . "\n" .
         'Search has returned no results' . "\n";
} else {
    echo 'Status: ' . $json->Status . "\n" .
         'Total results: ' . count($json->Entries) . "\n\n";

    foreach ( $json->Entries as $contact ) {
        $groups = array();
        if ( !empty($contact->Groups) ) {
            $groups = $contact->Groups;
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
                        