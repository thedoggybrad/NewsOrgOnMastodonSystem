<?php
// This PHP script is used to fetch the RSS Feed of Philippine Inquirer through curl
// It is used because for some reason normal bot user agents are not allowed to crawl the RSS Feed

// URL of the RSS feed
$rss_url = 'https://www.inquirer.net/feed/';

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $rss_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

// Execute cURL session
$rss_content = curl_exec($ch);

// Check for cURL errors
if ($rss_content === false) {
    echo "Failed to fetch RSS feed using cURL: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Get HTTP status code
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session
curl_close($ch);

// Check HTTP status code
if ($http_code >= 200 && $http_code < 300) {
    // Save the RSS content to rss.xml
    $file_path = 'rss.xml';
    $saved = file_put_contents($file_path, $rss_content);
    
    if ($saved !== false) {
        echo "RSS feed successfully copied to rss.xml";
    } else {
        echo "Failed to save RSS feed to rss.xml";
    }
} else {
    echo "Failed to fetch RSS feed. HTTP status code: $http_code";
}

?>
