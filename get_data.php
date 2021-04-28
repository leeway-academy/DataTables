<?php

try {
    $conn = new PDO('sqlite:dt.sq3');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

$orderBy = " ORDER BY ";
foreach ($_GET['order'] as $order) {
    $orderBy .= $order['column'] + 1 . " {$order['dir']}, ";
}

$orderBy = substr($orderBy, 0, -2);
$where = '';

$columns = $_GET['columns'];
$fields = ['id', 'name', 'price'];
$where = '';

foreach ($columns as $k => $column) {
    if ($search = $column['search']['value']) {
        $where .= $fields[$k].' = '.$search.' AND ';
    }
}

$where = substr($where, 0, -5);
$length = $_GET['length'];
$start = $_GET['start'];

$countSql = "SELECT count(id) as Total FROM products";
$countSt = $conn
    ->query($countSql);

$total = $countSt->fetch()['Total'];

$sql = "SELECT * FROM products ".($where ?? "WHERE $where ")."$orderBy LIMIT $length OFFSET $start";
$st = $conn
    ->query($sql);

if ($st) {
    $rs = $st->fetchAll(PDO::FETCH_FUNC, fn($id, $name, $price) => [$id, $name, $price] );

    echo json_encode([
        'data' => $rs,
        'recordsTotal' => $total,
        'recordsFiltered' => count($rs),
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}
