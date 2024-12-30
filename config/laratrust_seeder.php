<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'owner' => [
            "Nursery-Profile" => true,
            "Manage-Classes"  => true,
            "Meal" => true,
            "NewsLetter" => true,
            "Parent-Request" => true,
            "Payment-History" => true,
            "Payment-Request" => true,
            "Nursery-Policy" => true,
            "Roles" => true,
            "Faq" => true
        ],
        'manager' => [],
        'teacher' => [],
        'parent' => [],
    ],
];
