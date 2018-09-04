<?php
$config = $_GET['config'] ?? null;
if (!$config) {
    throw new \Exception('请指定config');
}
$file = __DIR__ . '/mysql/' . $config . '.json';
if (!file_exists($file)) {
    throw new \Exception($config . '不存在');
}
$json = json_decode(file_get_contents($file));
$dbh = new PDO(
    "mysql:host={$json->host};port={$json->port};dbname={$json->database}",
    $json->user,
    $json->password,
    [
        PDO::ATTR_PERSISTENT => $json->persistent
    ]
);

$stmt = $dbh->prepare($json->sql);
$stmt->execute();
while (false !== $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    print_r($result);
}
