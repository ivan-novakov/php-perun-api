<?php

namespace InoPerunApi\Client\Serializer;

use InoPerunApi\Client\Payload;


interface SerializerInterface
{


    /**
     * Returns the code of the serializer.
     * 
     * return string
     */
    public function getCode();


    /**
     * Returns the MIME type of the serialized data.
     * 
     * @return string
     */
    public function getMimeType();


    /**
     * Serializes the payload.
     * 
     * @param Payload $payload
     * @return string
     */
    public function serialize(Payload $payload);


    /**
     * Unserializes data into a payload.
     * 
     * @param string $data
     * @return Payload
     */
    public function unserialize($data, Payload $payload);
}