<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/ForgotPasswordService.php';

$service = new ForgotPasswordService($conn);

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $service->requestReset($email);

    $pesan = "Link reset password telah dikirim, cek Email kamu.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
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
        .pw-container {
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
            width: 94%;
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
        p {
            text-align: center;
            color: #0019FF;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="pw-container">
    <h2>Kamu lupa Password?</h2>
    <p style="font-size: 14px; color: black;">Tenang, Masukkan email kamu yang sudah terdaftar.</p>

    <form action="" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" placeholder="Masukkan email kamu.."required><br><br>
            <?php if(isset($pesan)) : ?>
                <p style="color: #0019FF; text-align: center;"><?= $pesan ?></p>
            <?php endif; ?>
        <button type="submit">Kirim</button>

        <p><a href="../../index.php">Kembali ke login</a></p>
    </form>
    </div>
</body>
</html>
