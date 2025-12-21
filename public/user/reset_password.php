<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/ForgotPasswordService.php';
    
$token = $_GET['token'] ?? '';
$service = new ForgotPasswordService($conn);

$pesan = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $konfirm = $_POST['konfirm'];

    if ($password == $konfirm) {

        if ($service->resetPassword($token, $password)) {
        echo "<script>
            alert ('PASSWORD BERHASIL DIUBAH')
            window.location.href='../../index.php';
            </script>";
        } else {
            $pesan = "Token tidak valid atau kadaluarsa.";
        }
        $pesan = "Konfirmasi Password Salah";
    }
}

?>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(10deg, #023AFF, #0019FF);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }   
    .reset-pw-container {
        background: #f7faffff;
        color: #0019FF;
        width: 350px;
        padding: 25px;
        padding-top:15px;
        border-radius: 10px;
        box-shadow: 0 0 7px rgba(255, 255, 255, 0.8);
    }
    h2 {
        text-align: center;
    }
    label {
        margin-bottom: 5px;
    }
    input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #bbb;
        border-radius: 5px;
        transition: 0.2s;
    }
    input:focus {
        border-color: #0019FF;
        outline: none;
    }
    button {
        background: #0019FF;
        border: none;
        width: 100%;
        margin-bottom: 15px;
        color: #f7faffff;
        border-radius: 5px;
        padding: 10px;
    }
    button:hover {
        background: #000e88ff;
    }
</style>
<body>
    
    
    <div class="reset-pw-container">
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <input type="hidden" name="token" value="<?= $token ?>">
            <label>Password Baru:</label><br>
            <input type="password" name="password" required><br><br>
            <label>Konfirmasi Password Baru:</label><br>
            <input type="password" name="konfirm" required><br><br>
                <?php if(isset($pesan)) : ?>
                    <p style="color: #e00404ff; text-align: center;"><?= $pesan ?></p>
                <?php endif; ?>
            <button type="submit">Reset Password</button>
        </form>
    </div>

</body>
