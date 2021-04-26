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
    $rs = $st->fetchAll(PDO::FETCH_FUNC, fn($id, $name, $price) => [$id, $name, $price] );

    echo json_encode([
        'data' => $rs,
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}
