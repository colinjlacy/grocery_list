<?php

$data = [
    0 => [
        'title' => 'List 1',
        'user_id' => '12',
        'items' => [
            'bananas',
            'oranges',
            'chicken',
            'scotch'
        ]
    ],
    1 => [
        'title' => 'List 2',
        'user_id' => '12',
        'items' => [
            'spinach',
            'pine sol',
            'dog food',
            'OJ'
        ]
    ],
    2 => [
        'title' => 'List 3',
        'user_id' => '12',
        'items' => [
            'lettuce',
            'pasta',
            'yogurt'
        ]
    ],
    3 => [
        'title' => 'List 4',
        'user_id' => '12',
        'items' => [
            'cereal',
            'tooth paste',
            'lemonade',
            'printer paper',
            'hot sauce'
        ]
    ]
];

echo json_encode($data);

?>