<?php

$data = array(
    'User'          => 'winnie',
    'Password'      => 'the-pooh',
    'sortBy'        => 'Name',
    'sortDir'       => 'asc',
    'itemsPerPage'  => '10',
    'page'          => '3',
);

$curl = curl_init('https://app.eztexting.com/groups?format=json&' . http_build_query($data));
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

    foreach ( $json->Entries as $group ) {
        echo 'Group ID : ' . $group->ID . "\n" .
             'Name: ' . $group->Name . "\n" .
             'Note: ' . $group->Note . "\n" .
             'Number of Contacts: ' . $group->ContactCount . "\n\n";
    }
}

?>
                        