# Mini LMS

Application de gestion de formations en ligne — cours, quiz et notes, avec deux rôles distincts : **Administrateur** et **Apprenant**.

Développé avec **Laravel 11**, **Tailwind CSS** et **SQLite**.

---

## Démarrage rapide

```bash
node start.js
```

Le script s'occupe de tout : installation des dépendances, configuration de la base de données, seeders, et lancement des serveurs. L'application sera disponible sur **http://localhost:8000**.

> **Prérequis** : PHP >= 8.2, Composer, Node.js >= 18 — fonctionne sur Windows, macOS et Linux.

---

## Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@lms.test | password |
| Apprenant | alice@lms.test | password |
| Apprenant | bob@lms.test | password |

---

## Fonctionnalités

**Administrateur**
- Gestion complète (CRUD) des formations, chapitres et sous-chapitres
- Ajout de contenus pédagogiques (texte libre, lien vidéo/ressource)
- Création de quiz avec questions QCM ou Vrai/Faux et réponses
- Inscription et retrait des apprenants d'une formation
- Consultation et saisie manuelle des notes

**Apprenant**
- Accès à sa formation, ses chapitres et ses contenus
- Réponse aux quiz avec calcul automatique du score (sur 20)
- Consultation de ses notes et résultats

---

## Données de démonstration incluses

Le seeder génère automatiquement :

- Une formation **"Anglais – Les verbes irréguliers"**
- 2 chapitres, 3 sous-chapitres avec contenus pédagogiques
- 2 quiz (8 questions + 3 questions) avec leurs réponses
- Les deux apprenants inscrits à la formation

---

## Réinitialiser la base de données

```bash
php artisan migrate:fresh --seed
```

---

## Structure

```
app/
├── Http/Controllers/
│   ├── FormationController.php
│   ├── ChapitreController.php
│   ├── SousChapitreController.php
│   ├── ContenuPedagogiqueController.php
│   ├── QuizController.php
│   ├── QuestionController.php
│   ├── ReponseController.php
│   ├── NoteController.php
│   └── QuizReponseController.php
└── Models/
    ├── User.php          (rôles : admin / apprenant)
    ├── Formation.php
    ├── Chapitre.php
    ├── SousChapitre.php
    ├── ContenuPedagogique.php
    ├── Quiz.php
    ├── Question.php
    ├── Reponse.php
    └── Note.php
```

Routes admin sous le préfixe `/admin/*`, routes apprenant sans préfixe, toutes protégées par `auth` + middleware de rôle.
