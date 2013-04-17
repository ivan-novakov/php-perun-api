<?php

namespace InoPerunApi\Client;

use InoPerunApi\Client\Serializer\SerializerInterface;
use InoPerunApi\Exception as GeneralException;
use Zend\Http;


class ResponseFactory
{

    /**
     * The payload factory.
     * 
     * @var PayloadFactory
     */
    protected $payloadFactory = null;

    /**
     * The serializer.
     * 
     * @var SerializerInterface
     */
    protected $serializer = null;


    public function setPayloadFactory(PayloadFactory $payloadFactory)
    {
        $this->payloadFactory = $payloadFactory;
    }


    /**
     * Returns the payload factory.
     * 
     * @return PayloadFactory
     */
    public function getPayloadFactory()
    {
        if (! $this->payloadFactory instanceof PayloadFactory) {
            $this->payloadFactory = new PayloadFactory();
        }
        return $this->payloadFactory;
    }


    /**
     * Sets the serializer.
     * 
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * Returns the serializer.
     * 
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }


    /**
     * Creates a Perun response from the HTTP response.
     * 
     * @param Http\Response $httpResponse
     * @param Request $request
     * @throws GeneralException\MissingDependencyException
     * @return Response
     */
    public function createResponseFromHttpResponse(Http\Response $httpResponse, Request $request)
    {
        $serializer = $this->getSerializer();
        if (! $serializer) {
            throw new GeneralException\MissingDependencyException('serializer', $this);
        }
        
        $payload = $this->getPayloadFactory()
            ->createPayload();
        $payload = $serializer->unserialize($httpResponse->getBody(), $payload);
        
        return $this->createResponseFromPayload($payload, $request);
    }


    /**
     * Creates a Perun response from a payload.
     * 
     * @param Payload $payload
     * @param Request $request
     * @return Response
     */
    public function createResponseFromPayload(Payload $payload, Request $request)
    {
        return new Response($request, $payload);
    }
}