<?php
/**
 * File for Module Class
 *
 * @category  User
 * @package   User
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */

/**
 * @namespace
 */
namespace User;

/**
 * @uses Zend\Module\Consumer\AutoloaderProvider
 * @uses Zend\EventManager\StaticEventManager
 */
use Zend\ModuleManager\ModuleManager;

/**
 * Module Class
 *
 * Handles Module Initialization
 *
 * @category  User
 * @package   User
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class Module
{
    /**
     * Init function
     *
     * @return void
     */
    public function init(ModuleManager $moduleManager)
    {
        $sharedManager = $moduleManager->getEventManager()->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Application', 'dispatch', array($this, 'mvcPreDispatch'), 100);
        $sharedManager->attach(__NAMESPACE__, 'dispatch', function($e) {
            $routeMatch = $e->getRouteMatch();
            $action     = $routeMatch->getParam('action');
            if($action != 'login'){
                $e->getViewModel()->setTemplate('layout/user');
            }
            
        }, 100);
    }

    /**
     * Get Autoloader Configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    /**
     * Get Module Configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * MVC preDispatch Event
     *
     * @param $event
     * @return mixed
     */
    public function mvcPreDispatch($event) {
        $di =  $event->getTarget()->getServiceManager();
        $auth = $di->get('User\Event\Authentication');
        return $auth->preDispatch($event);
    }
}
