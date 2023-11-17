import pandas as pd

# Charger le dataset principal
dataset = pd.read_csv('dataset.csv')

# Charger le fichier de correspondance
correspondance = pd.read_csv('correspondance.csv')

# Fusionner les deux dataframes sur la colonne "Arrondissement"
result = pd.merge(dataset, correspondance, on='Arrondissement')

# Enregistrer le résultat dans un nouveau fichier CSV
result.to_csv('dataset_with_coordinates.csv', index=False)
