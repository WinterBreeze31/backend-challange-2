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

function clean($data)
{
    $data = preg_replace('@[^A-Za-z0-9\w\ ]@', '', $data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    
    return $data;
}


    $listId = clean($_POST['listId']);
    $itemId = clean($_POST['itemId']);
    $itemStatus = clean($_POST['itemStatus']);
    $itemName = clean($_POST['itemName']);
    $itemPriority = clean($_POST['itemPriority']);
    $itemDuration = clean($_POST['itemDuration']);
    $itemContent = clean($_POST['itemContent']);
    
        
  


if (isset($_POST['editItem'])){

    

    $stmt = $pdo->prepare("UPDATE `listitem` SET `name` = ?, `content` = ?, `priority` = ?, `status` = ?, `duration` = ? WHERE `listitem`.`id` = ?; ");
    $stmt->execute([$itemName, $itemContent, $itemPriority, $itemStatus, $itemDuration, $itemId]);

}

if (isset($_POST['newItem'])){


    $stmt = $pdo->prepare("INSERT INTO `listitem` (`id`, `listId`, `name`, `content`, `priority`, `status`, `duration`) VALUES (NULL, ?, ?, ?, ?, 1, ?);");
    $stmt->execute([$listId, $itemName, $itemContent, $itemPriority, $itemDuration]);

}

if (isset($_POST['deleteItem'])){


    $stmt = $pdo->prepare("DELETE FROM `listitem` WHERE `listitem`.`id` = ?");
    $stmt->execute([$itemId]);

}

if (isset($_POST['editList'])){

   
    $stmt = $pdo->prepare("UPDATE `list` SET `name` = ? WHERE `list`.`id` = ?; ");
    $stmt->execute([$itemName, $itemId]);

}


if (isset($_POST['deleteList'])){


    $stmt = $pdo->prepare("DELETE FROM `list` WHERE `list`.`id` = ?");
    $stmt->execute([$itemId]);

}

if (isset($_POST['makeList'])){

    $stmt = $pdo->prepare("INSERT INTO `list` (`id`, `name`) VALUES (NULL, ?);");
    $stmt->execute([$itemName]);

}