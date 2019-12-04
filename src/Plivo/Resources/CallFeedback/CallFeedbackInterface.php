<?php

namespace Plivo\Resources\CallFeedback;

use Plivo\Exceptions\PlivoValidationException;
use Plivo\Exceptions\PlivoResponseException;
use Plivo\BaseClient;
use Plivo\Resources\ResourceInterface;
use Plivo\Resources\ResourceList;

use Plivo\Resources\ResponseUpdate;
use Plivo\Util\ArrayOperations;

/**
 * Class CallFeedbackInterface
 * @package Plivo\Resources\CallFeedback
 */
class CallFeedbackInterface extends ResourceInterface
{
    const CALLINSIGHTS_BASE_URL = "http://localhost:5000";
    const CALLINSIGHTS_API_VERSION = "v1";
    /**
     * CallFeedbackInterface constructor.
     * @param BaseClient $plivoClient
     * @param string $authId
     */
    function __construct(BaseClient $plivoClient)
    {
        parent::__construct($plivoClient);
        $this->uri = "v1/Call/";
    }

    public function create($callUUID, $rating, $issues=[], $notes="")
    {
        $mandatoryArgs = [
            'callUUID' => $callUUID,
            'rating' => $rating
        ];

        $optionalArgs = [];
        if (count($issues) > 0) {
            $optionalArgs['issues'] = $issues;
        }

        if (strlen($notes) > 0) {
            $optionalArgs['notes'] = $notes;
        }

        $optionalArgs['isCallInsightsRequest'] = TRUE;
        $requestPath = sprintf("Call/%s/Feedback/", $callUUID);
        $optionalArgs['CallInsightsEndpoint'] = sprintf("%s/%s/%s", self::CALLINSIGHTS_BASE_URL, self::CALLINSIGHTS_API_VERSION, $requestPath);

        if (ArrayOperations::checkNull($mandatoryArgs)) {
            throw new PlivoValidationException(
                "Mandatory parameters cannot be null");
        }

        $response = $this->client->update(
            $this->uri,
            array_merge($mandatoryArgs, $optionalArgs)
        );

        $responseContents = $response->getContent();
        print_r($responseContents);
        if(!array_key_exists("error",$responseContents)){
            return new CallFeedbackCreateResponse(
                none,
                $responseContents['message'],
                $response->getStatusCode()
            );
        } else {
            throw new PlivoResponseException(
                $responseContents['error'],
                0,
                null,
                $response->getContent(),
                $response->getStatusCode()

            );
        }
        
    }

}