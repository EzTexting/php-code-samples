<?php

$data = array(
    'User'              => 'winnie',
    'Password'          => 'the-pooh',
    'EnableDoubleOptIn' => true,
    'ConfirmMessage'    => 'Reply Y to join our sweetest list',
    'JoinMessage'       => 'The only reason for being a bee that I know of, is to make honey. And the only reason for making honey, is so as I can eat it.',
    'ForwardEmail'      => 'honey@bear-alliance.co.uk',
    'ForwardUrl'        => 'http://bear-alliance.co.uk/honey-donations/',
    'ContactGroupIDs'   => array('honey lovers')
);

$curl = curl_init('https://app.eztexting.com/keywords/honey?format=json');
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
    echo 'Status: ' . $json->Status . "\n" .
         'Keyword ID: ' . $json->Entry->ID . "\n" .
         'Keyword: ' . $json->Entry->Keyword . "\n" .
         'Is double opt-in enabled: ' . (int) $json->Entry->EnableDoubleOptIn . "\n" .
         'Confirm message: ' . $json->Entry->ConfirmMessage . "\n" .
         'Join message: ' . $json->Entry->JoinMessage . "\n" .
         'Forward email: ' . $json->Entry->ForwardEmail . "\n" .
         'Forward url: ' . $json->Entry->ForwardUrl . "\n" .
         'Groups: ' . implode(', ' , $json->Entry->ContactGroupIDs) . "\n";
}

?>