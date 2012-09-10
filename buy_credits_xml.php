<?php

$data = array(
    'User'             => 'winnie',
    'Password'         => 'the-pooh',
    'NumberOfCredits'  => '1000',
    'CouponCode'       => 'honey2011',
    'StoredCreditCard' => '1111'
);

$curl = curl_init('https://app.eztexting.com/billing/credits?format=xml');
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
         'Credits purchased: ' . $xml->Entry->BoughtCredits . "\n" .
         'Amount charged, $: ' . sprintf("%01.2f", $xml->Entry->Amount) . "\n" .
         'Discount, $: ' . sprintf("%01.2f", $xml->Entry->Discount) . "\n" .
         'Plan credits: ' . $xml->Entry->PlanCredits . "\n" .
         'Anytime credits: ' . $xml->Entry->AnytimeCredits . "\n" .
         'Total: ' . $xml->Entry->TotalCredits . "\n";
}

?>
                    