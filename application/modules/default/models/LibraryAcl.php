<?php
/**
 * 
 * Model_LibraryAcl - Access Control List
 * Rozszerza Zend_Acl
 *
 */
class Model_LibraryAcl extends Zend_Acl {

    public function __construct() {
        $this->addRole(new Zend_Acl_Role('guests'));
        $this->addRole(new Zend_Acl_Role('clients'), 'guests');
        $this->addRole(new Zend_Acl_Role('users'), 'clients');
        $this->addRole(new Zend_Acl_Role('supporters'), 'users');
        $this->addRole(new Zend_Acl_Role('experts'), 'supporters');
        $this->addRole(new Zend_Acl_role('admins'), 'experts');



        $this->addResource(new Zend_Acl_Resource('stat'));

        $this->addResource(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin:user'), 'admin')
                ->add(new Zend_Acl_Resource('admin:users'), 'admin')
                ->add(new Zend_Acl_Resource('admin:email'), 'admin');

        $this->addResource(new Zend_Acl_Resource('client'))
                ->add(new Zend_Acl_Resource('client:tickets'), 'client')
                ->add(new Zend_Acl_Resource('client:ticket'), 'client');

        $this->addResource(new Zend_Acl_Resource('default'))
                ->add(new Zend_Acl_Resource('default:authentication'), 'default')
                ->add(new Zend_Acl_Resource('default:index'), 'default')
                ->add(new Zend_Acl_Resource('default:profile'), 'default')
                ->add(new Zend_Acl_Resource('default:error'), 'default')
                ->add(new Zend_Acl_Resource('default:register'), 'default')
                ->add(new Zend_Acl_Resource('default:language'), 'default');

        $this->addResource(new Zend_Acl_Resource('support'))
                ->addResource(new Zend_Acl_Resource('support:srq'), 'support')
                ->addResource(new Zend_Acl_Resource('support:srqs'), 'support')
                ->addResource(new Zend_Acl_Resource('support:ticket'), 'support')
                ->addResource(new Zend_Acl_Resource('support:tickets'), 'support')
                ->addResource(new Zend_Acl_Resource('support:stat'));


        $this->allow('guests', 'default:authentication', 'login')
                ->allow('guests', 'default:error', 'error')
                ->allow('guests', 'default:register', 'registeruser')
                ->allow('guests','default:language','switch');

        //klienci
        $this->allow('clients', 'default:index', 'index')
                ->allow('clients', 'default:authentication', 'logout')
                ->allow('clients', 'client:tickets', array('list','index'))
                ->allow('clients', 'client:ticket', array('index', 'add', 'show', 'answer'))
                ->allow('clients','default:profile',array('index','changepassword'))
                ->allow('clients','stat','client')
                ->deny('clients', 'default:authentication', 'login')
                ->deny('clients', 'default:register', 'registeruser');
        
        //suporterzy

        $this->allow('supporters', 'support:srq', array('add','show','simplysolve'))
                ->allow('supporters', 'support:srqs', 'list')
                ->allow('supporters', 'support:ticket', array('add','cancel', 'edit', 'index','changepriority','changecategory','show','addanswer','addsupportrequest','setresponsibility'))
                ->allow('supporters', 'support:tickets', array('list','responsible'))
                ->deny('supporters', array('client:ticket','client:tickets'))
                ->allow('supporters','stat','support')
                ->deny('supporters','stat','client');

        //eksperci
        $this->allow('experts', 'support', 'index')
                ->allow('experts', 'support:srq', array('edit', 'solve', 'index','changedepartment'))
                ->deny('experts', 'support:srq', 'simplysolve');

        //administratorzy
        $this->allow('admins', 'admin', 'index')
                ->allow('admins', 'admin:users', array('list','premissions'))
                ->allow('admins','stat','admin')
                ->allow('admins', 'support:stat', array('index', 'users','experts','save'))
                ->allow('admins', 'admin:user', array('add', 'delete', 'edit','password','editpremissions','deletepremission','deletepremission'))
                ->allow('admins', 'admin:email','preferences');
    }

}
