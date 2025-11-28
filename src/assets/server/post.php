<?php

function add_register()
{
    $filePath = './contacts.json';
    if (file_exists($filePath)) {
        $registers = json_decode(file_get_contents($filePath));
        $registers[] = (object)[
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'age' => $_POST['age'],
            'phone' => $_POST['phone'],
            'suggestions' => $_POST['suggestions']
        ];
        file_put_contents($filePath, json_encode($registers));
    } else {
        file_put_contents($filePath, "[]");
        add_register();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_register();
}