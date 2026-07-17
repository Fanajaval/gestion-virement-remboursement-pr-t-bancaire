<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Connexion - BankOnline</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        .test-section {
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        h2 {
            font-size: 20px;
            margin-bottom: 15px;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
        ul {
            margin: 15px 0 0 30px;
        }
        li {
            margin: 8px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 10px 0 0;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5568d3;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Test de Configuration - BankOnline</h1>

        <?php
        $allTestsPassed = true;

        // Test 1: Version PHP
        echo '<div class="test-section ' . (version_compare(PHP_VERSION, '5.5.0', '>=') ? 'success' : 'error') . '">';
        echo '<h2><span class="icon">📋</span>Test 1 : Version PHP</h2>';
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            echo '<p> PHP version : <strong>' . PHP_VERSION . '</strong> (OK)</p>';
        } else {
            echo '<p> PHP version trop ancienne : ' . PHP_VERSION . ' (Minimum requis : 5.5.0)</p>';
            $allTestsPassed = false;
        }
        echo '</div>';

        // Test 2: Extensions PHP
        echo '<div class="test-section info">';
        echo '<h2><span class="icon">🔌</span>Test 2 : Extensions PHP</h2>';
        $extensions = ['mysqli', 'mbstring', 'openssl', 'ctype', 'filter', 'hash'];
        $missingExtensions = [];
        echo '<ul>';
        foreach ($extensions as $ext) {
            if (extension_loaded($ext)) {
                echo '<li>✅ ' . $ext . '</li>';
            } else {
                echo '<li>❌ ' . $ext . ' (Manquant)</li>';
                $missingExtensions[] = $ext;
            }
        }
        echo '</ul>';
        if (empty($missingExtensions)) {
            echo '<p>✅ Toutes les extensions nécessaires sont installées</p>';
        } else {
            echo '<p>⚠️ Extensions manquantes : ' . implode(', ', $missingExtensions) . '</p>';
        }
        echo '</div>';

        // Test 3: Connexion à la base de données
        include_once 'db.php';
        echo '<div class="test-section ' . ($conn->connect_error ? 'error' : 'success') . '">';
        echo '<h2><span class="icon">🗄️</span>Test 3 : Connexion à la Base de Données</h2>';
        if ($conn->connect_error) {
            echo '<p>❌ Échec de connexion : ' . $conn->connect_error . '</p>';
            echo '<p><strong>Solution :</strong> Vérifiez que MySQL est démarré dans XAMPP</p>';
            $allTestsPassed = false;
        } else {
            echo '<p>✅ Connexion à MySQL réussie</p>';
            echo '<p>📊 Base de données : <strong>virement_pret_bancaire</strong></p>';
            
            // Vérifier les tables
            $tables = ['utilisateur', 'client', 'virement', 'preter', 'rendre', 'password_reset_tokens'];
            $missingTables = [];
            $existingTables = [];
            
            foreach ($tables as $table) {
                $result = $conn->query("SHOW TABLES LIKE '$table'");
                if ($result && $result->num_rows > 0) {
                    $existingTables[] = $table;
                    // Compter les lignes
                    $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
                    $count = $countResult->fetch_assoc()['count'];
                    echo '<p>✅ Table <code>' . $table . '</code> existe (' . $count . ' enregistrements)</p>';
                } else {
                    $missingTables[] = $table;
                }
            }
            
            if (!empty($missingTables)) {
                echo '<div style="background:#fff3cd;padding:15px;margin-top:15px;border-radius:5px;">';
                echo '<p><strong>⚠️ Tables manquantes :</strong></p>';
                echo '<ul>';
                foreach ($missingTables as $table) {
                    echo '<li>' . $table . '</li>';
                }
                echo '</ul>';
                echo '<p><strong>Solution :</strong> Exécutez le fichier <code>setup_database.sql</code> dans phpMyAdmin</p>';
                echo '</div>';
                $allTestsPassed = false;
            }
        }
        echo '</div>';

        // Test 4: Fichiers requis
        echo '<div class="test-section info">';
        echo '<h2><span class="icon">📁</span>Test 4 : Fichiers du Projet</h2>';
        $requiredFiles = [
            'login.php' => 'Page de connexion',
            'head.php' => 'Page d\'accueil',
            'client_banq.php' => 'Gestion des clients',
            'db.php' => 'Configuration BDD',
            'logout.php' => 'Déconnexion'
        ];
        echo '<table>';
        echo '<tr><th>Fichier</th><th>Description</th><th>Statut</th></tr>';
        foreach ($requiredFiles as $file => $desc) {
            $exists = file_exists($file);
            echo '<tr>';
            echo '<td><code>' . $file . '</code></td>';
            echo '<td>' . $desc . '</td>';
            echo '<td>' . ($exists ? '✅ Existe' : '❌ Manquant') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';

        // Test 5: Comptes de test
        if (!$conn->connect_error) {
            $testAccounts = $conn->query("SELECT email, role FROM utilisateur");
            if ($testAccounts && $testAccounts->num_rows > 0) {
                echo '<div class="test-section success">';
                echo '<h2><span class="icon">👤</span>Test 5 : Comptes Disponibles</h2>';
                echo '<table>';
                echo '<tr><th>Email</th><th>Rôle</th><th>Mot de passe (test)</th></tr>';
                while ($account = $testAccounts->fetch_assoc()) {
                    $pwd = ($account['role'] === 'admin') ? 'admin123' : 
                           (($account['role'] === 'employe') ? 'employe123' : 'client123');
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($account['email']) . '</td>';
                    echo '<td><strong>' . htmlspecialchars($account['role']) . '</strong></td>';
                    echo '<td><code>' . $pwd . '</code></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            }
        }

        // Résumé final
        echo '<div class="test-section ' . ($allTestsPassed ? 'success' : 'warning') . '">';
        echo '<h2><span class="icon">🎯</span>Résumé</h2>';
        if ($allTestsPassed) {
            echo '<p style="font-size:18px;"><strong>✅ Tous les tests sont passés avec succès!</strong></p>';
            echo '<p>Votre environnement est correctement configuré. Vous pouvez maintenant utiliser l\'application.</p>';
            echo '<a href="login.php" class="btn btn-success">🚀 Accéder à la Page de Connexion</a>';
        } else {
            echo '<p style="font-size:18px;"><strong>⚠️ Certains tests ont échoué</strong></p>';
            echo '<p>Veuillez corriger les erreurs ci-dessus avant de continuer.</p>';
            echo '<p><strong>Étapes recommandées :</strong></p>';
            echo '<ol style="margin-left:30px;">';
            echo '<li>Vérifiez que XAMPP est démarré (Apache + MySQL)</li>';
            echo '<li>Ouvrez phpMyAdmin : <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>';
            echo '<li>Importez le fichier <code>setup_database.sql</code></li>';
            echo '<li>Rafraîchissez cette page</li>';
            echo '</ol>';
        }
        echo '<a href="test_connexion.php" class="btn">🔄 Relancer les Tests</a>';
        echo '<a href="README_INSTALLATION.md" class="btn">📖 Guide d\'Installation</a>';
        echo '</div>';
        ?>

    </div>
</body>
</html>
