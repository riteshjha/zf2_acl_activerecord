<?php
/**
 * File for Auth Adapter Class
 *
 * @category  User
 * @author    Ritesh Jha (mailrkj@gmail.com)
 */

namespace User\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthenticationResult;
use User\Model\User;

class Adapter implements AdapterInterface {

    /**
     * Digest authentication user
     *
     * @var string
     */
    protected $email;

    /**
     * Password for the user of the realm
     *
     * @var string
     */
    protected $password;

   /**
     * Sets the username option value
     *
     * @param  mixed $email
     * @return Digest Provides a fluent interface
     */
    public function setIdentity($email) {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * Sets the password option value
     *
     * @param  mixed $password
     * @return Digest Provides a fluent interface
     */
    public function setCredential($password) {
        $this->password = (string) $password;
        return $this;
    }

    /**
     * Defined by Zend\Authentication\Adapter\AdapterInterface
     *
     * @throws Exception\ExceptionInterface
     * @return AuthenticationResult
     */
    public function authenticate() {
        $user = User::find_by_email_and_password($this->email, md5($this->password));

        if ($user) {
            $result['code'] = AuthenticationResult::SUCCESS;
            $result['identity'] = $user;
            $result['messages']['success'] = 'Logged in';
        } else {
            $result['code'] = AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND;
            $result['messages']['invalid'] = "Email '$this->email' and password combination not found";
            $result['identity']= false;
        }

        return new AuthenticationResult($result['code'], $result['identity'], $result['messages']);
    }

}