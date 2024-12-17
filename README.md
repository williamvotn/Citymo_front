# Citymo - Recherche Immobilière à Paris
![image](https://github.com/user-attachments/assets/7b8c78ca-3f50-4a14-b6de-da2326695a14)

## Introduction

Bienvenue dans Citymo, un outil de recherche immobilière vous permettant de trouver tous les appartements à vendre dans Paris.

## Lancement du Projet

Pour lancer le projet, suivez ces étapes simples :

1. **Login Docker :** Connectez-vous à Docker à l'aide de la commande suivante :

```
docker login
```

Saisissez votre nom d'utilisateur et votre mot de passe Docker lorsque vous y êtes invité.

2. **Pull des Containers :** Récupérez les images Docker nécessaires en exécutant les commandes suivantes :

```
docker pull williamvotn/citymo_front:latest
```
puis
```
docker pull williamvotn/citymo_bdd:latest
```

3. **Dossier Docker-Compose :** Assurez-vous d'être dans le dossier contenant le fichier `docker-compose.yml`.

4. **Lancement de l'Application :** Démarrez l'application avec la commande :

```
docker-compose up -d
```

L'application sera disponible à l'adresse http://localhost:8080 dans votre navigateur.

## Utilisation

1. Accédez à http://localhost:8080 dans votre navigateur.

2. Utilisez les fonctionnalités de recherche pour trouver des appartements à vendre à Paris.

## Besoin d'aide ?

Si vous avez des problèmes ou des questions, n'hésitez pas à nous contacter à [william.vothanh@gmail.com].

---

Merci d'utiliser Citymo ! Nous espérons que vous trouverez votre appartement idéal à Paris.
