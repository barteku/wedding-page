<?php

namespace Acme\DemoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
/**
 * Description of GuestAdmin
 *
 * @author bartek
 */
class GuestAdmin extends BaseAdmin {

    public function getNewInstance()
    {
        $class = $this->getClass();

        return new $class('', array());
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullname')
            ->add('token')
            ->add('email') 
            ->add('has_partner', 'boolean', array(
                'editable' => true
            ))  
            ->add('confirmed', 'boolean', array(
                'editable' => true
            ))     
            ->add('_action', 'actions', array(
                'actions' => array(
                    //'show' => array(),
                    'edit' => array(),
                    'delete' => array()
                )
            ))
            
        ;
    }

    
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('has_partner', null, array('required' => false))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('first_name')
            ->add('last_name')
            ->add('email')
        ;
    }
    
    public function prePersist($object) {
        $object->setToken(md5('wesela asi i bartka - ' . $object->getFullName() . date('Y-m-d H:i:s')));
    }
    
}
