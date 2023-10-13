import sys
import argparse
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.preprocessing import MinMaxScaler
import time
from geopy.distance import geodesic
import matplotlib.pyplot as plt
import numpy as np


# Exemple d'utilisation :
# python3 recommandation/recommandation.py 2022-1369861 --bonus 2022-1363613

# Enregistrer le moment où le programme commence
start_time = time.time()

# Définition des arguments en ligne de commande
parser = argparse.ArgumentParser(description="Script de recommandation d'appartements.")
parser.add_argument('reference_id', type=str, help="ID de l'appartement de référence")
parser.add_argument('--bonus', type=str, help="ID de l'appartement à exclure du calcul de la similarité")
args = parser.parse_args()

# Lire le fichier CSV
df = pd.read_csv('dataset/paris.csv')

# Trouver l'index de l'appartement de référence dans le DataFrame
reference_index = df[df['id_mutation'] == args.reference_id].index[0]

# Exclure l'appartement spécifié par le paramètre bonus (s'il est fourni)
if args.bonus:
    df = df[df['id_mutation'] != args.bonus]

# Sélectionner les colonnes pour le calcul de la similarité
columns_to_compare = ['valeur_fonciere', 'surface_reelle_bati', 'nombre_pieces_principales', 'longitude', 'latitude']

# Créer un sous-dataframe avec les colonnes à normaliser
data_to_normalize = df[columns_to_compare]

# Normaliser les données
scaler = MinMaxScaler()
normalized_data = scaler.fit_transform(data_to_normalize)
normalized_df = pd.DataFrame(normalized_data, columns=columns_to_compare)

# Calculer la similarité cosinus avec l'appartement de référence
cosine_similarities = cosine_similarity(normalized_df, [normalized_df.iloc[reference_index]])

# Ajouter une colonne avec la similarité cosinus au DataFrame d'origine
df['cosine_similarity'] = cosine_similarities

# Trier le DataFrame en fonction de la similarité cosinus (en ordre décroissant)
df_sorted = df.sort_values(by='cosine_similarity', ascending=False)

# Conserver uniquement les 15 premières lignes du DataFrame trié (à partir de la deuxième ligne)
#df_sorted = df_sorted.iloc[1:].head(10000)
df_sorted = df_sorted.iloc[:].head(10000)

# Créer le graphique en fonction des valeurs normalisées
plt.figure(figsize=(12, 8))
plt.scatter(df_sorted['latitude'], df_sorted['longitude'], c=df_sorted['cosine_similarity'], cmap='viridis', marker='o', s=10)
plt.scatter(df_sorted.iloc[0]['latitude'], df_sorted.iloc[0]['longitude'], color='red', marker='*', s=200, label='Référence')
plt.xlabel('Latitude (normalisée)')
plt.ylabel('Longitude (normalisée)')
plt.title('Recommandations en fonction de la similarité cosinus')
plt.legend()
plt.colorbar(label='Similarité Cosinus')

# Définir les limites des axes pour couvrir l'intervalle
plt.xlim(48.819913, 48.900565)
plt.ylim(2.257019, 2.410847)

# Enregistrer le graphique
plt.savefig('recommandation/old-recommandation/top10klatlong.png')

# Supprimer la colonne 'cosine_similarity' avant de sauvegarder le CSV
df_sorted.drop(columns=['cosine_similarity'], inplace=True)

# Enregistrer le DataFrame trié dans un nouveau fichier CSV
df_sorted.to_csv('recommandation/old-recommandation/top10klatlong.csv', index=False)

# Enregistrer le moment où le programme se termine
end_time = time.time()

# Calculer la durée totale d'exécution
execution_time = end_time - start_time
print(f"Temps d'exécution : {execution_time} secondes")