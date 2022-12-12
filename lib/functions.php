<?php
//adding $limit = null means that if there is no $limit argument passed, then it is just set to null
function get_pets($limit = null)
{
    //common way to do configuration
    $config = require 'config.php';

    $pdo = new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass']
    );

    //so our contact page can still get all pets, no matter what, if null is passed as the limit
    $query = 'SELECT * FROM pet';
    if($limit){
        $query = $query.' LIMIT '.$limit;
    }
    $result = $pdo->query($query);
    $pets = $result->fetchAll();

    return $pets;
}

function save_pets($petsToSave){
    $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);
}
