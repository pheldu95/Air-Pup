<?php
function get_connection(){
    //connect to our database
    //common way to do configuration
    $config = require 'config.php';

    $pdo = new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass']
    );

    //so we can see what errors we are getting from SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}
function get_pets($limit = null)
{
    //^^^adding $limit = null means that if there is no $limit argument passed, then it is just set to null

    $pdo = get_connection();

    //so our contact page can still get all pets, no matter what, if null is passed as the limit
    $query = 'SELECT * FROM pet';
    if($limit){
        $query = $query.' LIMIT :resultLimit';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam('resultLimit', $limit, PDO::PARAM_INT);//PDO::PARAM_INT tells SQL this value is an integer not a string
    $stmt->execute();
    $pets = $stmt->fetchAll();

    return $pets;
}

function get_pet($id){
    $pdo = get_connection();

    $query = 'SELECT * FROM pet WHERE id = :idVal';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam('idVal', $id);    //tell mysql that :idVal is the $id variable for the pet
    $stmt->execute(); //make the query

    //use fetch here instead of fetchAll, fetchAll is to return mutliple rows. fetch is just one
    return $stmt->fetch();
}
function save_pets($petsToSave){
    $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);
}
