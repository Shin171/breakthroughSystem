<?php
$version = $_GET['version'];
$book = urlencode($_GET['book']);
$chapter = $_GET['chapter'];
$verse = isset($_GET['verse']) ? $_GET['verse'] : null;

$url = $verse
    ? "https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/{$version}/books/{$book}/chapters/{$chapter}/verses/{$verse}.json"
    : "https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/{$version}/books/{$book}/chapters/{$chapter}.json";

$response = file_get_contents($url);
$http_code = $http_response_header[0] ?? 'HTTP/1.1 500';
$content_type = '';

foreach ($http_response_header as $header) {
    if (stripos($header, 'Content-Type') === 0) {
        $content_type = $header;
        break;
    }
}

if (strpos($http_code, '200') === false || stripos($content_type, 'application/json') === false) {
    echo json_encode(["error" => "Invalid response from API. Please check the URL and parameters."]);
    exit;
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON response from API."]);
    exit;
}

echo json_encode($data);
?>
