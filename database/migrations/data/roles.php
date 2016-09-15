<?php
return [
    [
        'name'              => 'Administrator',
        'description'       => null,
        'has_full_access'   => true,
        'parent_name'       => null,
    ],
    [
        'name'              => 'Committee Member',
        'description'       => null,
        'has_full_access'   => false,
        'parent_name'       => 'Member',
    ],
    [
        'name'              => 'Member',
        'description'       => null,
        'has_full_access'   => false,
        'parent_name'       => 'Past Member',
    ],
    [
        'name'              => 'Past Member',
        'description'       => null,
        'has_full_access'   => false,
        'parent_name'       => 'Guest',
    ],
    [
        'name'              => 'Outside Coach',
        'description'       => null,
        'has_full_access'   => false,
        'parent_name'       => 'Guest',
    ],
    [
        'name'              => 'Guest',
        'description'       => null,
        'has_full_access'   => false,
        'parent_name'       => null,
    ],
];