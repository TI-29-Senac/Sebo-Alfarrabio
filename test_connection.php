<?php
$url = 'http://localhost:3020/backend/index.php/api/item';
$headers = @get_headers($url);
if ($headers) {
    echo "Headers for $url:\n";
    print_r($headers);
} else {
    echo "Failed to connect to $url\n";
}

$url2 = 'http://localhost:3020/index.php/api/item';
$headers2 = @get_headers($url2);
if ($headers2) {
    echo "Headers for $url2:\n";
    print_r($headers2);
} else {
    echo "Failed to connect to $url2\n";
}
