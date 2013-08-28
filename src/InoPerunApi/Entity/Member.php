<?php

namespace InoPerunApi\Entity;


/**
 * The "member entity. Represents membership in a VO - relation between the user and the VO entity.
 * 
 * @link http://perun.metacentrum.cz/javadoc/cz/metacentrum/perun/core/api/Member.html
 * 
 * @method integer getUserId()
 * @method integer getVoId()
 * @method string getStatus()
 * @method \InoPerunApi\Entity\User getUser()
 */
class Member extends GenericEntity
{

    protected $entityBeanName = 'Member';
    
    
    /*
    public function getRichUser()
    {
        $user = $this->getUser();
        
        $richUser = new RichUser($user->getProperties());
        $richUser->setUserAttribtues($this->getUserAttributes());
        
        return $richUser;
    }
    */
}