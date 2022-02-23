<?php
$host = '127.0.0.1';
$db   = 'todolist';
$user = 'root';
$pass = 'mysql';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST['editItem'])){

    $itemId = $_POST['itemId'];
    $itemStatus = $_POST['itemStatus'];
    $itemName = $_POST['itemName'];
    $itemPriority = $_POST['itemPriority'];
    $itemDuration = $_POST['itemDuration'];
    $itemContent = $_POST['itemContent'];

    $stmt = $pdo->prepare("UPDATE `listitem` SET `name` = ?, `content` = ?, `priority` = ?, `status` = ?, `duration` = ? WHERE `listitem`.`id` = ?; ");
    $stmt->execute([$itemName, $itemContent, $itemPriority, $itemStatus, $itemDuration, $itemId]);

}

if (isset($_POST['newItem'])){

    $listId = $_POST['listId'];
    $itemName = $_POST['itemName'];
    $itemPriority = $_POST['itemPriority'];
    $itemDuration = $_POST['itemDuration'];
    $itemContent = $_POST['itemContent'];

    $stmt = $pdo->prepare("INSERT INTO `listitem` (`id`, `listId`, `name`, `content`, `priority`, `status`, `duration`) VALUES (NULL, ?, ?, ?, ?, 1, ?);");
    $stmt->execute([$listId, $itemName, $itemContent, $itemPriority, $itemDuration]);

}

if (isset($_POST['deleteItem'])){

    $itemId = $_POST['itemId'];

    $stmt = $pdo->prepare("DELETE FROM `listitem` WHERE `listitem`.`id` = ?");
    $stmt->execute([$itemId]);

}