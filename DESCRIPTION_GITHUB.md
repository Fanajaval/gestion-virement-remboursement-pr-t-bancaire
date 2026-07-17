# 🏦 BankOnline - Système de Gestion Bancaire

## Description Courte (pour le repository GitHub)

**Français :**
```
Système de gestion bancaire complet développé en PHP/MySQL. Gère les clients, virements, prêts et remboursements avec génération de rapports PDF et notifications par email.
```

**English :**
```
Complete banking management system built with PHP/MySQL. Manages clients, transfers, loans and repayments with PDF report generation and email notifications.
```

---

## Description Complète

### 📝 À propos

**BankOnline** est une application web de gestion bancaire développée en PHP et MySQL, conçue pour gérer les opérations courantes d'une institution financière. Le système offre une interface intuitive pour la gestion des clients, des transactions financières, et le suivi des prêts.

### ✨ Fonctionnalités Principales

- 👥 **Gestion des Clients** : Création, modification et suppression de comptes clients
- 💸 **Virements Bancaires** : Transferts d'argent entre comptes avec validation des soldes
- 💰 **Gestion des Prêts** : Octroi de prêts avec calcul automatique des frais (10%)
- 📊 **Suivi des Remboursements** : Gestion complète des remboursements partiels ou totaux
- 📈 **Tableau de Bord** : Statistiques en temps réel sur les opérations bancaires
- 📄 **Rapports PDF** : Génération de rapports financiers exportables
- 📧 **Notifications Email** : Alertes automatiques pour les prêts et remboursements
- 🔐 **Authentification Sécurisée** : Système multi-rôles (Admin/Employé) avec récupération de mot de passe

### 🛠️ Technologies Utilisées

- **Backend** : PHP 5.5+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript
- **Bibliothèques** : 
  - FPDF (génération de PDF)
  - PHPMailer (envoi d'emails)
- **Serveur** : Apache (XAMPP)

### 🚀 Installation Rapide

```bash
# 1. Cloner le repository
git clone https://github.com/votre-username/bankonline.git

# 2. Importer la base de données
# Ouvrir phpMyAdmin et importer setup_database.sql

# 3. Configurer la connexion
# Modifier db.php avec vos paramètres MySQL

# 4. Accéder à l'application
# http://localhost/Gestion de virements et prêts bancaires/login.php
```

Pour une installation détaillée, consultez [README_INSTALLATION.md](README_INSTALLATION.md)

### 📸 Captures d'écran

*(Ajoutez vos captures d'écran ici)*

### 🎯 Cas d'Utilisation

- Microfinance et institutions de crédit
- Coopératives d'épargne et de crédit
- Systèmes de gestion interne pour petites banques
- Projets académiques et formations en développement web

### 📋 Prérequis

- PHP 5.5 ou supérieur
- MySQL 5.6 ou supérieur
- Apache (ou XAMPP/WAMP)
- Extensions PHP : mysqli, mbstring, openssl

### 📖 Documentation

- [Guide d'Installation](README_INSTALLATION.md) - Installation complète pas à pas
- [Structure de la Base de Données](setup_database.sql) - Schéma SQL complet
- [Configuration Email](README_INSTALLATION.md#-installation-de-phpmailer-envoi-demails---optionnel) - Guide PHPMailer

### 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
- 🐛 Signaler des bugs
- 💡 Proposer de nouvelles fonctionnalités
- 🔧 Soumettre des pull requests

### 📄 Licence

Ce projet est sous licence [votre licence]. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

### 👨‍💻 Auteur

**Votre Nom**
- GitHub: [@votre-username](https://github.com/votre-username)
- Email: votre.email@example.com

### 🙏 Remerciements

- Merci à tous les contributeurs
- FPDF pour la génération de PDF
- PHPMailer pour l'envoi d'emails

---

**⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile !**

