

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Upload IGC</title>
</head>
<body>
<h1>Wczytaj plik IGC</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['igc_file'])) {
    $fileTmp = $_FILES['igc_file']['tmp_name'];
    $fileName = $_FILES['igc_file']['name'];

    $positions = [];

    function parse_igc_line($line) {
        if (substr($line, 0, 1) !== 'B') return null;

        $hh = intval(substr($line, 1, 2));
        $mm = intval(substr($line, 3, 2));
        $ss = intval(substr($line, 5, 2));
        $time_str = sprintf("%02d:%02d:%02d", $hh, $mm, $ss);

        $lat_deg = intval(substr($line, 7, 2));
        $lat_min = floatval(substr($line, 9, 5)) / 1000;
        $lat_hem = substr($line, 14, 1);
        $latitude = $lat_deg + $lat_min / 60;
        if ($lat_hem === 'S') $latitude = -$latitude;

        $lon_deg = intval(substr($line, 15, 3));
        $lon_min = floatval(substr($line, 18, 5)) / 1000;
        $lon_hem = substr($line, 23, 1);
        $longitude = $lon_deg + $lon_min / 60;
        if ($lon_hem === 'W') $longitude = -$longitude;

        $altitude = intval(substr($line, 25, 5));

        return [
            "time" => $time_str,
            "latitude" => round($latitude, 6),
            "longitude" => round($longitude, 6),
            "altitude" => $altitude
        ];
    }

    $lines = file($fileTmp, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = parse_igc_line(trim($line));
        if ($data) $positions[] = $data;
    }

    file_put_contents('path.json', json_encode($positions, JSON_PRETTY_PRINT));

    echo "Plik JSON został zapisany. <a href='visualization.html'>Otwórz wizualizację</a>";
    exit;
}
?>


<form method="post" enctype="multipart/form-data">
    <input type="file" name="igc_file" accept=".igc" required>
    <button type="submit">Konwertuj na JSON</button>
</form>
</body>
</html>

