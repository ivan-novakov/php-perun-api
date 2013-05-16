<?php

namespace InoPerunApi\Entity;


/**
 * The "RichUser" entity.
 * 
 * @method \InoPerunApi\Entity\Collection\Collection getUserExtSources()
 * @method \InoPerunApi\Entity\Collection\Collection getUserAttributes()
 */
class RichUser extends User
{

    protected $entityBeanName = 'RichUser';
}