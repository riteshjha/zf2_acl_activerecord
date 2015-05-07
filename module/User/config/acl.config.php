<?php
return array(
    'acl' => array(
        'roles' => array(
            'guest'   => null,
            'member'  => 'guest'
        ),
        'resources' => array(
            'allow' => array(
                'Application\Controller\Index' => array(
                    'all'   => 'guest'
                ),
                
                'User\Controller\User' => array(
                    'login' => 'guest',
                    'all'   => 'member'
                ),
                
                'Album\Controller\Album' => array(
                    'all'   => 'member'
                )
            )
        )
    )
);
