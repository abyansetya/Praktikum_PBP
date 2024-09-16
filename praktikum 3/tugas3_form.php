<!-- Nama : Abyan Setyaneva -->
<!-- NIM  : 24060122130058 -->
<!-- LAB  : B1 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
</head>
<body>
    <?php
    // Inisialisasi pesan error dan variabel input
    $nisErr = $namaErr = $ekstraErr = "";
    $nis = $nama = $gender = $kelas = "";
    $ekstrakurikuler = [];

    // Jika tombol submit ditekan
    if (isset($_POST["submit"])) {
        // Validasi NIS
        if (empty($_POST["nis"])) {
            $nisErr = "NIS harus diisi";
        } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
            $nisErr = "NIS harus terdiri dari 10 karakter angka";
        } else {
            $nis = $_POST["nis"];
        }

        // Validasi Nama
        if (empty($_POST["nama"])) {
            $namaErr = "Nama harus diisi";
        } else {
            $nama = test_input($_POST["nama"]);
        }

        // Validasi Jenis Kelamin
        if (!empty($_POST["gender"])) {
            $gender = $_POST["gender"];
        }

        // Validasi Kelas
        if (!empty($_POST["kelas"])) {
            $kelas = $_POST["kelas"];
        }

        // Validasi Ekstrakurikuler (hanya untuk kelas X dan XI)
        if ($kelas != "XII") {
            if (empty($_POST["ekstrakurikuler"])) {
                $ekstraErr = "Pilih minimal 1 kegiatan ekstrakurikuler";
            } elseif (count($_POST["ekstrakurikuler"]) > 3) {
                $ekstraErr = "Maksimal pilih 3 kegiatan ekstrakurikuler";
            } else {
                $ekstrakurikuler = $_POST["ekstrakurikuler"];
            }
        }
    }

    // Fungsi untuk membersihkan input agar aman dari karakter yang tidak diinginkan
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <h2>Form Input Siswa</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        NIS: <input type="text" name="nis" value="<?php echo $nis; ?>">
        <span style="color: red;">* <?php echo $nisErr; ?></span><br><br>

        Nama: <input type="text" name="nama" value="<?php echo $nama; ?>">
        <span style="color: red;">* <?php echo $namaErr; ?></span><br><br>

        Jenis Kelamin:
        <input type="radio" name="gender" value="Pria" <?php if ($gender == "Pria") echo "checked";?>> Pria
        <input type="radio" name="gender" value="Wanita" <?php if ($gender == "Wanita") echo "checked";?>> Wanita
        <br><br>

        Kelas:
        <select name="kelas">
            <option value="X" <?php if ($kelas == "X") echo "selected";?>>X</option>
            <option value="XI" <?php if ($kelas == "XI") echo "selected";?>>XI</option>
            <option value="XII" <?php if ($kelas == "XII") echo "selected";?>>XII</option>
        </select>
        <br><br>

        <?php if ($kelas != "XII") : ?>
        Ekstrakurikuler: <br>
        <input type="checkbox" name="ekstrakurikuler[]" value="Pramuka" <?php if (in_array("Pramuka", $ekstrakurikuler)) echo "checked";?>> Pramuka <br>
        <input type="checkbox" name="ekstrakurikuler[]" value="Seni Tari" <?php if (in_array("Seni Tari", $ekstrakurikuler)) echo "checked";?>> Seni Tari <br>
        <input type="checkbox" name="ekstrakurikuler[]" value="Sinematografi" <?php if (in_array("Sinematografi", $ekstrakurikuler)) echo "checked";?>> Sinematografi <br>
        <input type="checkbox" name="ekstrakurikuler[]" value="Basket" <?php if (in_array("Basket", $ekstrakurikuler)) echo "checked";?>> Basket <br>
        <span style="color: red;">* <?php echo $ekstraErr; ?></span><br><br>
        <?php endif; ?>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>

    <?php
    // Menampilkan data yang diinput jika valid
    if (isset($_POST["submit"]) && !$nisErr && !$namaErr && !$ekstraErr) {
        echo "<h2>Data yang Diinput:</h2>";
        echo "NIS: " . $nis . "<br>";
        echo "Nama: " . $nama . "<br>";
        echo "Jenis Kelamin: " . $gender . "<br>";
        echo "Kelas: " . $kelas . "<br>";
        if ($kelas != "XII") {
            echo "Ekstrakurikuler: " . implode(", ", $ekstrakurikuler) . "<br>";
        }
    }
    ?>
</body>
</html>
