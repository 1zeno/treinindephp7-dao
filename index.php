<?php

require_once("config.php");

// //Carrega um usuário

// $root = new Usuario();

// $root -> loadbyid(5);

// echo $root;


// //Carrega uma lista de usuários
// $lista = Usuario::getList();

// echo json_encode($lista);

// //Carrega uma lista de usuários buscando pelo login

// $search = Usuario::search('funcionaporfavor');

// echo json_encode($search);

//Carrega um usuario usando login e senha

$usuario = new Usuario();

$usuario -> login("teste","testando");

echo $usuario;
?>