<?php

namespace momopsdk\Disbursement\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Disbursement\Models\GetAccBalance;

class GetBalance extends BaseProcess
{
    /**
     * Subscription Key
     */
    private $subscriptionKey;

    /**
     * Target Environment
     */
    private $targetEnvironment;

    public function __construct($sSubsKey, $sTargetEnvironment)
    {
        CommonUtil::validateArgument(
            $sSubsKey,
            'Subscription Key',
            CommonUtil::TYPE_STRING
        );
        $this->subscriptionKey = $sSubsKey;
        $this->targetEnvironment = $sTargetEnvironment;
        return $this;
    }

    /**
     * Function to execute the API for API key generation
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::get(API::GET_ACCOUNT_BALANCE)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnvironment)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setSubscriptionKey($this->subscriptionKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new GetAccBalance());
    }
}