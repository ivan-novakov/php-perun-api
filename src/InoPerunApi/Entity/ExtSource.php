<?php

namespace InoPerunApi\Entity;


/**
 * The "ExtSource" entity.
 * 
 * @see http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/ExtSource.html
 * 
 * @method string getName()
 * @method string getType()
 * @method \InoPerunApi\Entity\Collection\AttributeCollection getAttributes()
 */
class ExtSource extends GenericEntity
{

    protected $entityBeanName = 'ExtSource';
}