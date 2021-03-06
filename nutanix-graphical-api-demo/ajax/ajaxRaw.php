<?php

require '../vendor/autoload.php';

try {

    $client = new \DigitalFormula\ApiRequest\ApiRequest(
        $_POST[ 'cluster-username' ],
        $_POST[ 'cluster-password' ],
        $_POST[ 'cvm-address' ],
        $_POST[ 'cluster-port' ],
        $_POST[ 'cluster-timeout' ]
    );

    /* get the response data in JSON format */
    $rawJSON = $client->get( '/PrismGateway/services/rest/v1/' . $_POST[ 'api-object' ] . '/' )->json();

    /* now that we've got all the info and arranged it nicely, return the JSON-formatted results back from the AJAX request */
    echo( json_encode( array(
        'result' => 'ok',
        'json' => $rawJSON,
    ) ) );

}
catch ( GuzzleHttp\Exception\RequestException $e ) {
    /* can't connect to CVM */
    echo( json_encode( array(
        'result' => 'failed',
        // 'message' => "An error occurred while connecting to the CVM at address $cvm_address.  Sorry about that.  Perhaps check your connection or credentials?"
        'message' => $e->getMessage()
    ) ) );
}
catch ( Exception $e ) {
    /* something else happened that we weren't prepared for ... */
    echo( json_encode( array(
        'result' => 'failed',
        'message' => $e->getMessage()
        // 'message' => 'An unknown error has occurred.  Sorry about that.  Give it another go shortly.  :)'
    ) ) );
}