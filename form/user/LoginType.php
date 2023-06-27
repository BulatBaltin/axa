<?php
// namespace form\user;
// use dmForm;

class LoginType extends dmForm {

function __construct(?array $user = null )
{
    $this->action = "log-in";
    $this->fields = [

        'username'  => [
            'label' => 'User name',
            'value' => $user['username'] ?? '',
        ],

        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'empty_data' => "1111",
            'placeholder' => ''
        ],
        'remember_me' => [
            'type' => 'checkbox',
            'label'  => 'Keep me logged in'
        ],

    ];

        $this->SetData($user);
        // $this->SetCollection($collections);
    }
}