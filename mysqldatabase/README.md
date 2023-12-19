- Pour build l'image docker :
```
docker build -t clementjosse/siteimmo:latest .
```
- Pour pull l'image docker depuis docker hub
```
docker pull clementjosse/siteimmo:latest
```
Si ça ne marche pas, il faut se login avec les identifiants docker hub avant :
```
docker login
```

- Pour run le conteneur :
```
docker run -d -p 5000:3306 --name siteimmo clementjosse/siteimmo:latest
```

- Pour se connecter à la base de donnée depuis "EXEC" sur Docker Desktop :
```
mysql -u root -p
```