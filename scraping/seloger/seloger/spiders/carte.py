import pandas as pd
import matplotlib.pyplot as plt

# Charger les données à partir du fichier CSV
data = pd.read_csv('correspondance.csv')

# Extraire les colonnes de latitude, longitude et arrondissement
latitude = data['Latitude']
longitude = data['Longitude']
arrondissement = data['Arrondissement']

# Créer un graphique de dispersion avec Matplotlib
plt.figure(figsize=(10, 8))
plt.scatter(longitude, latitude, c='blue', marker='o', label='Arrondissement')

# Ajouter des étiquettes pour chaque point (arrondissement)
for i, txt in enumerate(arrondissement):
    plt.annotate(txt, (longitude[i], latitude[i]), fontsize=8, ha='right')

# Ajouter des labels et un titre
plt.xlabel('Longitude')
plt.ylabel('Latitude')
plt.title('Carte des Arrondissements de Paris')

# Afficher la carte
plt.grid(True)
plt.legend()
plt.show()
