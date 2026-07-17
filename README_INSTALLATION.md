# 🚀 Guide d'Installation et d'Exécution

## Prérequis
- **XAMPP** ou **WAMP** installé (Apache + MySQL + PHP)
- **Navigateur web** moderne
- **Composer** (optionnel, pour PHPMailer)

---

## 📋 Étapes d'Installation

### Étape 1 : Démarrer les Services XAMPP

1. Ouvrir le **XAMPP Control Panel**
2. Cliquer sur **"Start"** pour **Apache** (serveur web)
3. Cliquer sur **"Start"** pour **MySQL** (base de données)

✅ Vérifiez que les deux services affichent un fond vert

---

### Étape 2 : Importer la Base de Données

**📁 Méthode Rapide (Recommandée) :**

1. Ouvrir votre navigateur et aller à : **`http://localhost/phpmyadmin`**
2. Cliquer sur l'onglet **"Importer"** en haut de la page
3. Cliquer sur **"Choisir un fichier"**
4. Sélectionner le fichier **`setup_database.sql`** (situé dans le dossier du projet)
5. Descendre en bas de la page et cliquer sur **"Exécuter"**

✅ **Résultat attendu :**
- Une base de données nommée `virement_pret_bancaire` est créée
- 6 tables sont créées : `utilisateur`, `client`, `virement`, `preter`, `rendre`, `password_reset_tokens`
- Un message de succès s'affiche

**💡 Alternative (Si l'import échoue) :**

Si l'importation du fichier ne fonctionne pas :
1. Dans phpMyAdmin, cliquer sur **"Nouvelle base de données"**
2. Nom : `virement_pret_bancaire`
3. Collation : `utf8_general_ci`
4. Cliquer sur **"Créer"**
5. Sélectionner cette base dans le menu de gauche
6. Aller dans l'onglet **"SQL"**
7. Ouvrir le fichier `setup_database.sql` avec un éditeur de texte
8. Copier tout le contenu et le coller dans la zone SQL
9. Cliquer sur **"Exécuter"**

---

### Étape 3 : Vérifier l'Installation

Aller sur : **`http://localhost/Gestion de virements et prêts bancaires/login.php`**

✅ **Si tout fonctionne :** Vous verrez la page de connexion (sans erreur)  
❌ **Si erreur "Unknown database" :** Retournez à l'Étape 2

---

## 👤 Créer votre Premier Compte

### 1. Accéder à l'Inscription

Aller sur : **`http://localhost/Gestion de virements et prêts bancaires/inscription.php`**

Choisir entre **Employé** ou **Administrateur**

---

### 2. Format des Identifiants ⚠️ IMPORTANT

**Pour un Employé :**
- Format obligatoire : `EMP` + **3 chiffres exactement**
- ✅ Exemples valides : `EMP001`, `EMP002`, `EMP150`, `EMP999`
- ❌ Exemples invalides : `EMP1`, `EMP12`, `EMPLOYE001`, `EMP1234`

**Pour un Administrateur :**
- Format obligatoire : `ADM` + **3 chiffres exactement**
- ✅ Exemples valides : `ADM001`, `ADM002`, `ADM100`, `ADM999`
- ❌ Exemples invalides : `ADM1`, `ADMIN001`, `ADM12`, `ADM1234`

---

### 3. Exemple d'Inscription

**Inscription Employé :**
```
Identifiant :    EMP001
Nom complet :    Jean Rakoto
Email :          jean@bankonline.com
Mot de passe :   VotreMotDePasse123
```

**Inscription Administrateur :**
```
Identifiant :    ADM001
Nom complet :    Admin Principal
Email :          admin@bankonline.com
Mot de passe :   VotreMotDePasse123
```

---

### 4. Se Connecter

Après l'inscription, vous serez redirigé vers la page de connexion.

**Se connecter avec :**
- Email : celui que vous avez enregistré
- Mot de passe : celui que vous avez choisi

---

## 📁 Structure du Projet

```
Gestion de virements et prêts bancaires/
├── login.php              # 🔐 Page de connexion
├── inscription.php        # ✍️ Choix du type d'inscription
├── inscription_employe.php # Inscription employé
├── inscription_admin.php   # Inscription administrateur
├── traitement.php         # Traitement des inscriptions
├── head.php              # 🏠 Page d'accueil après connexion
├── client_banq.php       # 👥 Gestion des clients
├── virement.php          # 💸 Gestion des virements
├── preter.php            # 💰 Gestion des prêts
├── rendre.php            # 📊 Gestion des remboursements
├── tableau_bord.php      # 📈 Tableau de bord/statistiques
├── rapport.php           # 📄 Génération de rapports
├── export_pdf.php        # 📑 Export PDF des transactions
├── forgot_pwd.php        # 🔑 Récupération de mot de passe
├── enter_token.php       # Token de réinitialisation
├── reset_pwd.php         # Réinitialisation mot de passe
├── db.php                # ⚙️ Configuration base de données
├── logout.php            # 🚪 Déconnexion
└── setup_database.sql    # 📋 Script de création BDD
```

---

## � Fonctionnalités Disponibles

✅ **Authentification**
- Connexion sécurisée avec sessions PHP
- Inscription multi-rôles (Admin, Employé)
- Récupération de mot de passe par email
- Gestion des tokens de réinitialisation

✅ **Gestion des Clients**
- Ajout/Modification/Suppression de clients
- Génération automatique des numéros de compte (C001, C002, etc.)
- Recherche par numéro de compte ou nom
- Gestion des soldes

✅ **Gestion des Virements**
- Virement entre comptes clients
- Historique des transactions
- Validation des soldes

✅ **Gestion des Prêts**
- Création de prêts avec taux d'intérêt
- Suivi du statut (en cours, remboursé, en retard)
- Durée en mois

✅ **Remboursements**
- Enregistrement des paiements
- Lien avec les prêts

✅ **Tableau de Bord**
- Statistiques en temps réel
- Vue d'ensemble des opérations

✅ **Rapports PDF**
- Export des transactions par période
- Rapports de virements, prêts et remboursements

---

## ⚠️ Dépannage

### Erreur : "Unknown database 'virement_pret_bancaire'"
**Cause :** La base de données n'a pas été créée  
**Solution :** Importez le fichier `setup_database.sql` via phpMyAdmin (Étape 2)

### Erreur : "Inscription refusée : Identité non reconnue"
**Cause :** Format d'identifiant incorrect  
**Solution :** Utilisez le format `EMP001` pour employé ou `ADM001` pour admin

### Page blanche
**Cause :** Erreur PHP non affichée  
**Solution :** 
1. Vérifiez que Apache et MySQL sont démarrés
2. Consultez les logs : `xampp/apache/logs/error.log`

### Impossible de se connecter
**Cause :** Email ou mot de passe incorrect  
**Solution :** Vérifiez vos identifiants ou créez un nouveau compte

### L'email de récupération ne part pas
**Cause :** PHPMailer n'est pas configuré  
**Solution :** 
1. Ouvrir `forgot_pwd.php`
2. Configurer les paramètres SMTP (Gmail, Outlook, etc.)
3. Installer les dépendances : `composer install`

---

## 🔧 Configuration de PHPMailer (Optionnel)

Pour activer l'envoi d'emails de récupération de mot de passe :

1. Installer Composer (si pas encore fait)
2. Ouvrir un terminal dans le dossier du projet
3. Exécuter : `composer install`
4. Éditer `forgot_pwd.php` et configurer :
   - Serveur SMTP (ex: smtp.gmail.com)
   - Port (587 ou 465)
   - Email et mot de passe SMTP

---

## 📄 Installation de FPDF (Génération de PDF)

Pour activer la génération de rapports PDF, vous devez installer la bibliothèque FPDF.

### Méthode Manuelle (Recommandée)

1. **Télécharger FPDF :**
   - Aller sur : http://www.fpdf.org/en/download.php
   - Télécharger le fichier ZIP (version 1.86 ou supérieure)
   - Ou télécharger depuis GitHub : https://github.com/Setasign/FPDF/archive/refs/tags/1.86.zip

2. **Extraire et Installer :**
   - Extraire le fichier ZIP téléchargé
   - Créer un dossier `fpdf` dans le répertoire du projet
   - Copier le fichier `fpdf.php` dans ce dossier

3. **Structure finale :**
   ```
   Gestion de virements et prêts bancaires/
   ├── fpdf/
   │   └── fpdf.php          ← Fichier FPDF ici
   ├── export_pdf.php
   ├── rapport.php
   └── ...
   ```

### Alternative : Installation avec Composer

Si vous avez Composer installé :
```bash
composer require setasign/fpdf
```

### Vérification

1. Aller sur la page **Rapports** : `http://localhost/Gestion de virements et prêts bancaires/rapport.php`
2. Sélectionner une période
3. Cliquer sur **"Télécharger PDF"**
4. Si un PDF se télécharge, l'installation est réussie ✅

---

## 📧 Installation de PHPMailer (Envoi d'emails - Optionnel)

Pour activer les notifications par email (prêts et remboursements), vous devez installer PHPMailer.

### Méthode Manuelle (Recommandée)

1. **Télécharger PHPMailer :**
   - Aller sur : https://github.com/PHPMailer/PHPMailer/releases
   - Télécharger le fichier ZIP de la dernière version (ex: 6.9.1)
   - Ou télécharger directement : https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip

2. **Extraire et Installer :**
   - Extraire le fichier ZIP téléchargé
   - Dans le dossier extrait, trouvez le dossier **src**
   - Créer un dossier `phpmailer` dans le répertoire du projet
   - Copier le dossier **src** dans `phpmailer/`

3. **Structure finale :**
   ```
   Gestion de virements et prêts bancaires/
   ├── phpmailer/
   │   └── src/
   │       ├── PHPMailer.php
   │       ├── SMTP.php
   │       ├── Exception.php
   │       └── ... (autres fichiers)
   ├── preter.php
   ├── rendre.php
   └── ...
   ```

### Alternative : Installation avec Composer

Si vous avez Composer installé :
```bash
composer require phpmailer/phpmailer
```

### Configuration Gmail (pour l'envoi d'emails)

1. **Créer un mot de passe d'application Gmail :**
   - Aller sur : https://myaccount.google.com/security
   - Activer la validation en deux étapes (obligatoire)
   - Chercher "Mots de passe des applications"
   - Générer un mot de passe pour "Autre (nom personnalisé)"
   - Noter le mot de passe généré (ex: `abcd efgh ijkl mnop`)

2. **Configurer dans preter.php et rendre.php :**
   - Ouvrir les fichiers `preter.php` et `rendre.php`
   - Trouver la section "Configuration SMTP"
   - Remplacer :
     ```php
     $mail->Username = 'votre.email@gmail.com'; // Votre email
     $mail->Password = 'votre mot de passe application'; // Mot de passe d'application Gmail
     ```
   - Par vos vraies informations

3. **Autres fournisseurs SMTP :**
   
   **Outlook/Hotmail :**
   ```php
   $mail->Host = 'smtp-mail.outlook.com';
   $mail->Username = 'votre.email@outlook.com';
   $mail->Password = 'votre_mot_de_passe';
   ```
   
   **Yahoo Mail :**
   ```php
   $mail->Host = 'smtp.mail.yahoo.com';
   $mail->Username = 'votre.email@yahoo.com';
   $mail->Password = 'votre_mot_de_passe_application';
   ```

### Fonctionnalités Email

Une fois PHPMailer installé et configuré :

✅ **Notifications de prêts** (preter.php)
- Email envoyé automatiquement au client lors de l'octroi d'un prêt
- Contient les détails du prêt et la date limite de remboursement

✅ **Notifications de remboursements** (rendre.php)
- Email envoyé automatiquement au client après chaque remboursement
- Affiche le montant remboursé et le solde restant
- Message de félicitations si le prêt est totalement remboursé

**Note :** Si PHPMailer n'est pas installé ou configuré, les prêts et remboursements fonctionneront normalement, mais sans envoi d'email.

---

## 🚀 Prochaines Améliorations Possibles

- 🔒 Chiffrement des mots de passe (password_hash)
- 📱 Interface responsive améliorée
- 📊 Graphiques pour les statistiques
- 🔍 Pagination des tableaux
- 🎨 Thème sombre/clair
- 📧 Notifications par email
- 🔐 Authentification à deux facteurs (2FA)
- 🌐 API REST
- 📤 Export Excel/CSV
- 🗄️ Historique des modifications
- 👤 Profils utilisateurs personnalisables

---

## 📞 Support

Si vous rencontrez des problèmes :
1. Vérifiez que XAMPP est démarré
2. Vérifiez que la base de données existe
3. Consultez les logs d'erreur Apache
4. Vérifiez les permissions des fichiers

---

**🎉 Bonne utilisation de BankOnline !**
