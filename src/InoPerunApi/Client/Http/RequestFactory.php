<?php

namespace InoPerunApi\Client\Http;

use InoPerunApi\Client\Request as PerunRequest;
use Zend\Http\Request as HttpRequest;
use InoPerunApi\Client\Serializer\SerializerInterface;


class RequestFactory
{

    /**
     * The serializer.
     * 
     * @var SerializerInterface
     */
    protected $serializer = null;


    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * Creates and configures a HTTP request based on the provided base URL and the Perun request object.
     * 
     * @param string $baseUrl
     * @param PerunRequest $perunRequest
     * @param HttpRequest $httpRequest
     * @return \Zend\Http\Request
     */
    public function createRequest($baseUrl, PerunRequest $perunRequest)
    {
        $httpRequest = new HttpRequest();
        
        $httpRequest->setUri($this->constructUrl($baseUrl, $perunRequest));
        
        if ($perunRequest->isChangeState()) {
            $serializedParams = $this->serializer->serialize($perunRequest->getPayload());
            $httpRequest->setMethod(HttpRequest::METHOD_POST);
            $httpRequest->setContent($serializedParams);
        } else {
            $params = $perunRequest->getPayload()
                ->getParams();
            $httpRequest->setMethod(HttpRequest::METHOD_GET);
            $httpRequest->getQuery()
                ->fromArray($params);
        }
        
        return $httpRequest;
    }


    public function constructUrl($baseUrl, PerunRequest $perunRequest)
    {
        return sprintf("%s/%s/%s/%s", $baseUrl, $this->serializer->getCode(), $perunRequest->getManagerName(), $perunRequest->getMethodName());
    }
}