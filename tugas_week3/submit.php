<!-- Kelompok 1 -->
<!-- Abyan Setyaneva              24060122130058 -->
<!-- David Cristian Batubara      24060122130094 -->
<!-- Gigih Haidar Falah           24060122130094 -->
<!-- Rizqi Wildan Gilan R.        24060122140114 -->
<!-- Adriel Silaban               24060120140095 -->


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $university = $_POST['university'];
    $program = $_POST['program'];
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : 'No hobbies selected';
    $password = $_POST['password'];
    $errors = []; // Deklarasi array errors dengan benar

    // Validasi username
    if (empty($username) || !preg_match("/^[a-zA-Z]+$/", $username)) {
        // Jika username kosong atau mengandung angka, masukkan pesan ke array errors
        $errors[] = "Username tidak boleh kosong dan hanya boleh mengandung huruf.";
    }

    //validasi email
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ){
        $errors[] = "Email tidak boleh kosong dan harus valid.";
    }

    //validasi university
    if(empty($university)){
        $errors[] = "Universitas tidak boleh kosong";
    }

    //validasi program studi
    if(empty($program)){
        $errors[] = "Program studi tidak boleh kosong";
    }

    
    // Validasi password
    if (empty($password) || !preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = "Password harus minimal 8 karakter, termasuk setidaknya satu huruf besar, satu huruf kecil, dan satu angka.";
    }


    // Cek apakah ada error
    if (!empty($errors)) {
        // Jika ada error, tampilkan alert untuk setiap pesan error dan kembalikan ke halaman utama
        echo "<script>
                alert('" . implode("\\n", $errors) . "');
                window.location.href = 'index.html';
              </script>";
    } else {
        // Tampilkan alert form berhasil disubmit
        echo "<script>alert('Form submitted successfully!');</script>";

        // Tampilkan hasil form
        echo "<h1>Form Submitted Successfully</h1>";
        echo "<p><strong>Username:</strong> $username</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>University:</strong> $university</p>";
        echo "<p><strong>Program:</strong> $program</p>";
        echo "<p><strong>Hobbies:</strong> $hobbies</p>";
    }
} else {
    echo "Error: Invalid request.";
}
?>
