<?php
include_once "PDO.php";

function GetAllComments()
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM comment ORDER BY created_at ASC");
  return $stmt->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = $userId "
      . "ORDER BY comment.created_at ASC"
  );
  return $stmt->fetchAll();
}

function GetAllCommentsFromPostId($postId)
{
  global $PDO;
  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = $postId "
      . "ORDER BY comment.created_at ASC"
  );
  return $stmt->fetchAll();
}

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;
  $reponse = $PDO->prepare("INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)");
  $reponse->execute(
    array(
      "userId" => $userId,
      "postId" => $postId,
      "comment" => $comment
    )
  );
}
