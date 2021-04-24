<?php

try {
    $conn = new PDO('sqlite:dt.sq3');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

$sql = "SELECT * FROM products";
$st = $conn
    ->query($sql);

if ($st) {
    $products = [];

    foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $products[] = array_values($row);
    }

    echo json_encode([
        'data' => $products,
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}