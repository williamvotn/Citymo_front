# Citymo
Citymo est un projet de recommandation d'appartement.
![image](https://github.com/WilliamVOTHANH/Site_immo_Front/assets/86595295/49d37c18-f744-437c-87ad-7c34ab67f24d)


### Requirements :
- Avoir installé Docker Desktop
- Avoir un CLI Git, ex: Git Bash (recommandé)

# 2 possibilités pour faire tourner le projet :
## - Via Docker hub
Avec cette possibilité, on va récupérer les images uploadées sur Docker hub et les faire tourner sur Docker Desktop.
### Connexion à Docker hub
```
docker login
```
### Récupération des images
```
docker pull clementjosse/siteimmo:latest
```
et
```
docker pull guillaume971/projet-immo:latest
```
### Lancer le projet 
```
docker-compose up -d
```
Le projet est ensuite accessible à l'addresse: 
http://localhost:8080/


## - Via git clone puis docker build en local
Avec cette possibilité, on va récupérer le code du projet, build les images docker localement et les faire tourner sur Docker Desktop.
### Récupération du projet
```
git clone git@github.com:WilliamVOTHANH/Site_immo_Front.git
```
### Build des images
Build de l'interface :
```
docker build -t citymo_front:latest ./WebApp
```
Build de la base de donnée :
```
docker build -t citymo_bdd:latest ./mysqldatabase
```
### Modification du docker-compose.yml
remplacer les noms des images du docker_compose par celles créées:
- Pour l'interface :
```
  web:
    image: guillaume971/projet-immo:latest

# A remplacer par :
  
  web:
    image: citymo_front:latest
```
- Pour la base de donnée :
```
  db:
    image: clementjosse/siteimmo:latest

# A remplacer par :
  
  db:
    image: citymo_bdd:latest
```
### Lancer le projet 
```
docker-compose up -d
```
Le projet est ensuite accessible à l'addresse: 
http://localhost:8080/
