<?php

namespace InoPerunApi\Entity;


/**
 * The "ExtSource" entity.
 * 
 * @link http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/ExtSource.html
 * 
 * @method string getName()
 * @method string getType()
 * @method \InoPerunApi\Entity\Collection\Collection getAttributes()
 */
class ExtSource extends GenericEntity
{

    protected $entityBeanName = 'ExtSource';
}