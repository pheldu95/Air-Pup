<?php
function get_connection(){
    //connect to our database
    //common way to do configuration
    $config = require 'config.php';

    return new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass']
    );
}
function get_pets($limit = null)
{
    //^^^adding $limit = null means that if there is no $limit argument passed, then it is just set to null

    $pdo = get_connection();

    //so our contact page can still get all pets, no matter what, if null is passed as the limit
    $query = 'SELECT * FROM pet';
    if($limit){
        $query = $query.' LIMIT '.$limit;
    }
    $result = $pdo->query($query);
    $pets = $result->fetchAll();

    return $pets;
}

function get_pet($id){
    $pdo = get_connection();
    //security hole here
    $query = 'SELECT * FROM pet WHERE id = ' . $id;
    $result = $pdo->query($query);

    //use fetch here instead of fetchAll, fetchAll is to return mutliple rows. fetch is just one
    return $result->fetch();
}
function save_pets($petsToSave){
    $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);
}
