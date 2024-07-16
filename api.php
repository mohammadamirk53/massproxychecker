<?php
function check_proxy($proxy) {
    $ch = curl_init('https://api.ipify.org/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);

    $output = curl_exec($ch);

    if (curl_errno($ch)) {
        return false;
    }

    curl_close($ch);
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proxies = explode("\n", trim($_POST['proxies']));
    $proxies = array_map('trim', $proxies);

    echo "<h1>Proxy Check Results</h1>";
    echo "<table border='1'>
            <tr>
                <th>Proxy</th>
                <th>Status</th>
            </tr>";

    foreach ($proxies as $proxy) {
        if (!empty($proxy)) {
            $status = check_proxy($proxy) ? 'Live' : 'Dead';
            echo "<tr>
                    <td>{$proxy}</td>
                    <td>{$status}</td>
                  </tr>";
        }
    }

    echo "</table>";
}
?>