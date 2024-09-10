<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$array_mhs = array(
    'Abdul' => array(89, 90, 54),
    'Budi' => array(98, 65, 74),
    'Nina' => array(67, 56, 84)
);

function hitung_rata($nilai) {
  return array_sum($nilai) / count($nilai);
}

function print_mhs($array_mhs) {
   
    echo "<table border='1'>";
    echo "<tr><th>Nama</th><th>Nilai 1</th><th>Nilai 2</th><th>Nilai 3</th><th>Rata2</th></tr>";

    foreach ($array_mhs as $nama => $nilai) {        
        $rata2 = hitung_rata($nilai);

        echo "<tr>";
        echo "<td>$nama<	/td>";
        echo "<td>{$nilai[0]}</td>";
        echo "<td>{$nilai[1]}</td>";
        echo "<td>{$nilai[2]}</td>";
        echo "<td>$rata2</td>";
        echo "</tr>";
    }
    echo "</table>";
}
print_mhs($array_mhs);
?>

</body>
</html>
