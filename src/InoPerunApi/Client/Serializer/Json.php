<?php

namespace InoPerunApi\Client\Serializer;

use InoPerunApi\Client\Payload;


class Json extends AbstractSerializer
{


    public function serialize(Payload $payload)
    {
        return $this->jsonEncode($payload->getParams());
    }


    public function unserialize($data, Payload $payload)
    {
        try {
            $params = $this->jsonDecode($data);
        } catch (\Exception $e) {
            throw new Exception\UnserializeException(sprintf("JSON decode exception: [%s] %s", get_class($e), $e->getMessage()));
        }
        
        $payload->setParams($params);
        return $payload;
    }


    public function jsonEncode(array $params)
    {
        return \Zend\Json\Json::encode($params);
    }


    public function jsonDecode($data)
    {
        return \Zend\Json\Json::decode($data, \Zend\Json\Json::TYPE_ARRAY);
    }
}