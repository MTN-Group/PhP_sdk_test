<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Disbursement\DisbursementTransaction;


try {

    /**
     * Construct request object and set desired parameters
     */
    $accountHolderId = '0248888736';
    $accountHolderIdType = 'msisdn';
    $request = DisbursementTransaction::validateAccountHolderStatus(
        $accountHolderId,
        $accountHolderIdType,
        $sDisbursementSubKey,
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
