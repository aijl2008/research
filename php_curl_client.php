<?php
if (php_sapi_name() != 'cli') {
    echo "<pre>";
}
$start = microtime(true);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.64.182:8888/api/info");
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "applicationId" => "5bf650a46974ce5763444e63",
    "file" => __FILE__,
    "line" => __LINE__,
    "message" => "这是由php模拟的消息",
    "trace" => [
        "第1行", "第2行", "第3行", "第4行", "第5行"
    ],
    "domain" => $_SERVER["host"] ?? "",
    "server_address" => $_SERVER["SERVER_ADDR"] ?? "",
    "request_url" => $_SERVER["REQUEST_URI"] ?? "",
    "user_agent" => $_SERVER["HTTP_USER_AGENT"] ?? "",
    "referer" => $_SERVER["HTTP_REFERER"] ?? "",
    "remote_address" => $_SERVER["REMOTE_ADDR"] ?? "",
    "extra" => json_encode($_SERVER),
)));

print_r(http_build_query(array(
    "applicationId" => "5bf650a46974ce5763444e63",
    "file" => __FILE__,
    "line" => __LINE__,
    "message" => "这是由curl模拟的消息",
    "trace" => [
        "第1行", "第2行", "第3行", "第4行", "第5行"
    ],
    "domain" => "",
    "server_address" => "",
    "request_url" => "",
    "user_agent" => "curl",
    "referer" => "",
    "remote_address" => "",
    "extra" => [],
)));

//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 100);
//curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500);
//curl_setopt($ch, CURLOPT);
//curl_setopt($ch, CURLOPT_VERBOSE, 1);
$output = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
if ($error) {
    echo "[" . curl_errno($ch) . "]" . $error . PHP_EOL;
} else {
    echo substr($output, 0, $info['header_size']);
}
curl_close($ch);
print_r($output);
$end = microtime(true);
echo "   namelookup_time:" . intval($info['namelookup_time'] * 1000) . PHP_EOL;
echo "      connect_time:" . intval($info['connect_time'] * 1000) . PHP_EOL;
echo "  pretransfer_time:" . intval($info['pretransfer_time'] * 1000) . PHP_EOL;
echo "starttransfer_time:" . intval($info['starttransfer_time'] * 1000) . PHP_EOL;
echo "                 -:" . intval(($info['total_time'] - $info['starttransfer_time']) * 1000) . PHP_EOL;
echo "        total_time:" . intval($info['total_time'] * 1000) . PHP_EOL;
echo "      Time elapsed:" . intval(($end - $start) * 1000) . PHP_EOL;