# Laravel Terrain Protection Calculator

## Description

Le **Terrain Protection Calculator** est une application Laravel utilisant **Inertia.js** et **Vue 3** pour calculer la surface protégée d'un terrain face à une tempête. L'algorithme utilise les altitudes du terrain pour déterminer quelles parties sont protégées.

---

## Prérequis

Avant d’installer le projet, assurez-vous d’avoir installé :

- **Docker & Docker Compose** (nécessaire pour Sail)
- **PHP 8.4**
- **Composer**
- **Node.js & npm**

---

## Installation

### Cloner le projet

```sh
git clone https://github.com/zemzemi/terrain-protection.git
cd terrain-protection
```

### Installer les dépendances PHP et JavaScript

```sh
composer install
npm install
```

### Configurer l’environnement

Copiez le fichier `.env.example` et configurez-le :

```sh
cp .env.example .env
```

Générez la clé d’application Laravel :

```sh
php artisan key:generate
```

### Démarrer l’environnement avec Laravel Sail

Si vous utilisez Sail, lancez les services Docker :

```sh
./vendor/bin/sail up -d
```

Puis exécutez les migrations :

```sh
./vendor/bin/sail artisan migrate
```

### Démarrer le serveur et le compilateur Vite

```sh
./vendor/bin/sail artisan serve
./vendor/bin/sail npm run dev
```

Accédez à [**http://localhost**](http://localhost) dans votre navigateur.

---

## Utilisation avec Makefile

Un **Makefile** est inclus pour simplifier les commandes Docker et Laravel. Voici quelques commandes utiles :

Démarrer l’environnement et installer les dépendances :

```sh
make install-dependencies
```

Démarrer le projet avec **Sail** :

```sh
make start
```

Arrêter les services Docker :

```sh
make stop
```

Recharger les containers :

```sh
make restart
```

Supprimer les containers et volumes :

```sh
make rm
```

Ouvrir une session shell dans le conteneur Laravel :

```sh
make bash
```

Réinstaller complètement le projet :

```sh
make reinstall
```

---

## Tests

Exécutez les tests PHPUnit avec :

```sh
make test
```

Ou si vous utilisez Sail :

```sh
./vendor/bin/sail test
```

---

## Licence

Ce projet est sous licence MIT.

**Développé avec ❤️ et Laravel + Vue.js + Inertia.js + Sail**
