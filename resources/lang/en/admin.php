<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'genre' => [
        'title' => 'Genres',

        'actions' => [
            'index' => 'Genres',
            'create' => 'New Genre',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            
        ],
    ],

    'licence' => [
        'title' => 'Licences',

        'actions' => [
            'index' => 'Licences',
            'create' => 'New Licence',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'descriptions' => 'Descriptions',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];