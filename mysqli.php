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
$link = mysqli_connect(($json->persistent ? 'p' : '') . $json->host . ':' . $json->port, $config->user, $json->password, $config->database);
if (mysqli_connect_errno()) {
    throw new \Exception(mysqli_connect_error());
}
if ($result = mysqli_query($link, $config->sql)) {
    while ($obj = mysqli_fetch_object($result)) {
        print_r($obj);
    }
    mysqli_free_result($result);
}
mysqli_close($link);