<?php

namespace InoPerunApi\Client\Serializer;


abstract class AbstractSerializer implements SerializerInterface
{

    /**
	 * The serializer "code".
	 * @var string
	 */
    protected $code = 'generic';

    /**
	 * The MIME type of the serialized data.
	 * @var string
	 */
    protected $mimeType = 'text/plain';


    /**
     * Sets the code of the serializer.
     * 
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Serializer\SerializerInterface::getCode()
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * Sets the MIME type of the serialized data.
     *
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Serializer\SerializerInterface::getMimeType()
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}
