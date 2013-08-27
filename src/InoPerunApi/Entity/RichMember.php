<?php

namespace InoPerunApi\Entity;


/**
 * The 'RichMember' entity. Contains information about the related user and VO entities.
 * 
 * @see http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/RichMember.html
 * 
 * @method \InoPerunApi\Entity\User getUser()
 * @method \InoPerunApi\Entity\Collection\Collection getUserExtSource()
 * @method \InoPerunApi\Entity\Collection\Collection getUserAttributes()
 * @method \InoPerunApi\Entity\Collection\Collection getMemberAttributes()
 */
class RichMember extends Member
{
    
    protected $entityBeanName = 'RichMember';
}