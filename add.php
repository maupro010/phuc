<?php
require_once 'pdo.php';

//get values
$title = $_POST['title'] ?? null;
$body = $_POST['body'] ?? null;
$author = $_POST['author'] ?? null;
$file_name = $_FILES['fileToUpload']['name'] ?? null;

//check values
if (!$title or !$body or !$author or !$file_name) {
    header('Location: create.php');
    exit;
}

//move file
move_uploaded_file($_FILES['fileToUpload']['tmp_name'], './uploads/'.$_FILES['fileToUpload']['name']);

//get PDO
$pdo = getPDO();

//Correct font
$pdo->exec('set names utf8');
//add to DB
$statement = $pdo->prepare('INSERT INTO posts(title, body, author,file_name) VALUES (:title, :body, :author,:file_name)');
$statement->bindValue(':title', $title);
$statement->bindValue(':body', $body);
$statement->bindValue(':author', $author);
$statement->bindValue(':file_name', $file_name);
$statement->execute();

header('Location: create.php');