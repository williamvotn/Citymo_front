import pandas as pd

# Charger le CSV dans un DataFrame
df = pd.read_csv("raw_data/75.csv")

# Supprimer toutes les lignes où la colonne 'type_local' contient 'Dépendance'
df = df[df['type_local'] != 'Dépendance']
df = df[df['type_local'] != 'Local industriel. commercial ou assimilé']

# Supprimer toutes les lignes où la colonne 'nature_mutation' n'est pas égale à 'Vente'
df = df[df['nature_mutation'] == 'Vente']

# Liste des colonnes à conserver
colonnes_a_conserver = [
    'id_mutation',
    'valeur_fonciere',
    'adresse_numero',
    'adresse_nom_voie',
    'code_postal',
    'surface_reelle_bati',
    'nombre_pieces_principales',
    'longitude',
    'latitude'
]

# Supprimer toutes les colonnes qui ne sont pas dans la liste
df = df[colonnes_a_conserver]

# Supprimer toutes les lignes avec des données manquantes
df = df.dropna()

# Sauvegarder le DataFrame résultant dans un nouveau fichier CSV
df.to_csv("raw_data/75_cleaned.csv", index=False)