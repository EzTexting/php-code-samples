<?php

$data = array(
    'User'      => 'winnie',
    'Password'  => 'the-pooh',
);

$curl = curl_init('https://app.eztexting.com/groups/162467?format=json&_method=DELETE');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// If you experience SSL issues, perhaps due to an outdated SSL cert
// on your own server, try uncommenting the line below
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
curl_close($curl);

if ( !empty($response) ) {
    $json = json_decode($response);
    $json = $json->Response;

    if ( 'Failure' == $json->Status ) {
        $errors = array();
        if ( !empty($json->Errors) ) {
            $errors = $json->Errors;
        }

        echo 'Status: ' . $json->Status . "\n" .
             'Errors: ' . implode(', ' , $errors) . "\n";
    }
} else {
    echo 'Status: Success' . "\n";
}

?>
                        