<?php

namespace InoPerunApi\Entity;


/**
 * The "member entity. Represents membership in a VO - relation between the user and the VO entity.
 * 
 * @see http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/Member.html
 * 
 * @method integer getUserId()
 * @method integer getVoId()
 * @method string getStatus()
 */
class Member extends GenericEntity
{

    protected $entityBeanName = 'Member';
}