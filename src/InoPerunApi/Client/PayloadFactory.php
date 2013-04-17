<?php

namespace InoPerunApi\Client;


class PayloadFactory
{


    /**
     * Creates a payload object from the provided data.
     * 
     * @param array|null $data
     * @throws Exception\InvalidPayloadDataException
     * @return Payload
     */
    public function createPayload($data = null)
    {
        if (null === $data) {
            return new Payload();
        }
        
        if (is_array($data)) {
            return new Payload($data);
        }
        
        throw new Exception\InvalidPayloadDataException('Payload data must be array or null');
    }
}