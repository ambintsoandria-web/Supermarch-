<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Supermarché</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2332 0%, #2c3e50 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            min-height: 100vh;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
        }

        .login-container .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-container .logo h1 {
            font-size: 32px;
            color: #1a2332;
        }

        .login-container .logo h1 span {
            color: #4CAF50;
        }

        .login-container .logo p {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #43a047;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #dc3545;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
        }

        .infos {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
        }

        .infos strong {
            color: #333;
        }

        .infos .row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <h1>🏪 <span>Super</span>Marché</h1>
            <p>Connexion à la caisse</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="/auth/login" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="login">👤 Login</label>
                <input type="text" name="login" id="login" placeholder="Entrez votre login" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">🔒 Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn-login">🔑 Se connecter</button>
        </form>

        <div class="infos">
            <div style="font-weight: 600; margin-bottom: 5px;">👨‍💻 Comptes de test :</div>
            <div class="row"><strong>Admin :</strong> <span>admin / admin123</span></div>
            <div class="row"><strong>Caissier :</strong> <span>caissier / caisse123</span></div>
        </div>
    </div>
</body>

</html>