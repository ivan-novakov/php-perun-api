<?php

namespace InoPerunApi\Entity;


/**
 * The "User" entity.
 * 
 * @see http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/User.html
 * 
 * @method string getFirstName()
 * @method string getLastName()
 */
class User extends GenericEntity
{

    protected $entityBeanName = 'User';
}