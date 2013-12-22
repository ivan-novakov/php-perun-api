<?php

namespace InoPerunApi\Entity;


/**
 * The 'RichMember' entity. Contains information about the related user and VO entities.
 * 
 * @link http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/RichMember.html
 * 
 * @method \InoPerunApi\Entity\User getUser()
 * @method \InoPerunApi\Entity\Collection\UserExtSourceCollection getUserExtSources()
 * @method \InoPerunApi\Entity\Collection\AttributeCollection getUserAttributes()
 * @method \InoPerunApi\Entity\Collection\AttributeCollection getMemberAttributes()
 */
class RichMember extends Member
{
    
    protected $entityBeanName = 'RichMember';
}