<?php

namespace InoPerunApi\Entity;


/**
 * The "UserExtSource" entity.
 * 
 * @link http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/UserExtSource.html
 * 
 * @method string getLogin()
 * @method integer getUserId()
 * @method integer getLoa()
 * @method InoPerunApi\Entity\ExtSource getExtSource()
 */
class UserExtSource extends GenericEntity
{

    protected $entityBeanName = 'UserExtSource';
}