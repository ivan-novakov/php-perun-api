<?php

namespace InoPerunApi\Client\Serializer;

use InoPerunApi\Client\Payload;


/**
 * JSON serializer.
 */
class Json extends AbstractSerializer
{

    /**
     * @see AbstractSerializer::$code
     * @var string
     */
    protected $code = 'json';

    /**
     * @see AbstractSerializer::$mimeType
     * @var string
     */
    protected $mimeType = 'application/json';


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Serializer\SerializerInterface::serialize()
     */
    public function serialize(Payload $payload)
    {
        return $this->jsonEncode($payload->getParams());
    }


    /**
     * {@inheritdoc}
     * @see \InoPerunApi\Client\Serializer\SerializerInterface::unserialize()
     */
    public function unserialize($data, Payload $payload)
    {
        try {
            $params = $this->jsonDecode($data);
        } catch (\Exception $e) {
            throw new Exception\UnserializeException(sprintf("JSON decode exception: [%s] %s", get_class($e), $e->getMessage()));
        }
        
        if (null !== $params) {
            if (is_array($params)) {
                $payload->setParams($params);
            } else {
                throw new Exception\UnexpectedResultException('Invalid unserialized data - must be array or null');
            }
        }
        
        return $payload;
    }


    public function jsonEncode(array $params)
    {
        /*
         * If the $params array is empty, the result JSON encoded value will be '[]', which causes the error:
         * "WRONGLY_FORMATTED_CONTENT (not a JSON Object)"
         */
        if (empty($params)) {
            return '{}';
        }
        return \Zend\Json\Json::encode($params);
    }


    public function jsonDecode($data)
    {
        return \Zend\Json\Json::decode($data, \Zend\Json\Json::TYPE_ARRAY);
    }
}