<?php

namespace momopsdk\Disbursement\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Disbursement\Models\ResponseModel;
use momopsdk\Disbursement\Models\DepositModel;

class CreateRefundV1 extends BaseProcess
{
    /**
     * Subscription Key
     */
    private $subscriptionKey;

    /**
     * Target Environment
     */
    private $targetEnvironment;
    
    /**
     * Request data
     */
    public $aReq;

    public $subType;

    public function __construct($oRefund, $sSubsKey, $sTargetEnvironment, $sCallBackUrl, $subType)
    {
        CommonUtil::validateArgument(
            $sSubsKey,
            'Subscription Key',
            CommonUtil::TYPE_STRING
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS, $sCallBackUrl);
        $this->subscriptionKey = $sSubsKey;
        $this->targetEnvironment = $sTargetEnvironment;
        $this->aReq = $oRefund;
        $this->subType = $subType;
        return $this;
       
    }

    /**
     * Function to execute the API for API key generation
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::post(
            str_replace('{subscriptionType}', $this->subType, API::CREATE_REFUND_V1),
            json_encode($this->aReq))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnvironment)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setSubscriptionKey($this->subscriptionKey)
            ->setReferenceId($this->referenceId);
        if ($this->callBackUrl != null) {
            $request = $request->httpHeader(Header::X_CALLBACK_URL, $this->callBackUrl);
        }
        $request = $request->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new ResponseModel());
    }
}
