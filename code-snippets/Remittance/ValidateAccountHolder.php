<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Remittance\Remittance;


try {

    /**
     * Construct request object and set desired parameters
     */
    $accountHolderId = '0248888736';
    $accountHolderIdType = 'msisdn';
    $sRemittanceSubKey = '6d69c1bd1f874a6aa548ee8b79f9578f';
    $targetEnvironment = 'sandbox';
    $request = Remittance::validateAccountHolderStatus(
        $accountHolderId,
        $accountHolderIdType,
        $sRemittanceSubKey,
        $targetEnvironment
    );

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
