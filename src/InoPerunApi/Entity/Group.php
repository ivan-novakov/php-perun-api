<?php

namespace InoPerunApi\Entity;


/**
 * Group entity.
 * 
 * @method string getName()
 * @method string getDescription()
 * @method integer getParentGroupId()
 * @method void setName(string $name)
 * @method void setDescription(string $description)
 * @method void setParentGroupId(integer $groupId)
 */
class Group extends GenericEntity
{

    const PROP_NAME = 'name';

    const PROP_PARENT_GROUP_ID = 'parentGroupId';

    protected $entityBeanName = 'Group';
}