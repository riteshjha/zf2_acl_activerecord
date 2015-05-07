<?php

/**
 * File for User Controller Class
 *
 * @category  User
 * @package   User_Controller
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
/**
 * @namespace
 */

namespace User\Controller;

/**
 * @uses Zend\Mvc\Controller\ActionController
 * @uses User\Form\Login
 */
use Zend\Mvc\Controller\AbstractActionController,
    User\Form\Login as LoginForm,
    User\Form\LoginFilter as LoginFilter;

/**
 * User Controller Class
 *
 * User Controller
 *
 * @category  User
 * @package   User_Controller
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class UserController extends AbstractActionController {

    /**
     * Index Action
     */
    public function indexAction() {
        
    }

    /**
     * Login Action
     *
     * @return array
     */
    public function loginAction() {
        $form = new LoginForm();
        $form->setInputFilter(new LoginFilter());

        $request = $this->getRequest();
        $errorMessage = '';

        if ($request->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $uAuth = $this->userAuthentication();
                $authAdapter = $uAuth->getAuthAdapter();
                $data = $form->getData();
                $authAdapter->setIdentity($data['email']);
                $authAdapter->setCredential($data['password']);
                $auth = $uAuth->getAuthService()->authenticate($authAdapter);
                
                if ($auth->isValid()) {
                    return $this->redirect()->toRoute('user');
                } else {
                    $errorMessage = $auth->getMessages();
                    $errorMessage = $errorMessage['invalid'];
                }
            }
        }

        return array('form' => $form, 'errorMessage' => $errorMessage);
    }

    /**
     * Logout Action
     */
    public function logoutAction() {
        $this->userAuthentication()->clearIdentity();
        return $this->redirect()->toRoute('user/login');
    }

}
