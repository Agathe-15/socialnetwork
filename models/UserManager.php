<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  // Préparer la requête SQL pour récupérer l'utilisateur avec le nom d'utilisateur donné
  global $PDO;
  $stmt = $PDO->prepare("SELECT id, password FROM user WHERE username = :username");
  $stmt->execute(['username' => $username]);

  // Récupérer l'utilisateur
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Vérifier si l'utilisateur existe et si le mot de passe est correct
  if ($user && password_verify($password, $user['password'])) {
    return $user['id'];
  } else {
    return -1;
  }
}
