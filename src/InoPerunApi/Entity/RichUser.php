<?php

namespace InoPerunApi\Entity;


/**
 * The "RichUser" entity.
 * 
 * @link http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/RichUser.html
 * 
 * @method \InoPerunApi\Entity\Collection\UserExtSourceCollection getUserExtSources()
 * @method \InoPerunApi\Entity\Collection\AttributeCollection getUserAttributes()
 */
class RichUser extends User
{

    protected $entityBeanName = 'RichUser';
}