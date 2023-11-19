import pandas as pd
import re

# Charger le fichier CSV
df = pd.read_csv('new_dataset.csv')

# Initialiser les colonnes
df['Surface'] = ""
df['Nombre de pièces'] = ""
df['Nombre de chambres'] = ""
df['Nombre de salles de bain'] = ""
df['Salles d\'eau'] = ""
df['Chauffage'] = ""
df['Cave'] = ""
df['Ascenseur'] = ""
df['Balcon'] = ""
df['Box'] = ""
df['Digicode'] = ""
df['Gardien'] = ""
df['Exposition'] = ""
df['Interphone'] = ""
df['Garage'] = ""
df['Parking'] = ""
df['Cheminée'] = ""
df['Alarme'] = ""
df['Climatisation'] = ""
df['Dépendance'] = ""
df['Terrasse'] = ""
df['Radiateurs'] = ""
df['Jardin'] = ""

# Parcourir chaque ligne du dataframe
for index, row in df.iterrows():
    features = row['Features']
    
    # Vérifier si la valeur est une chaîne de caractères
    if isinstance(features, str):
        # Extraire les informations à partir de la colonne "Features"
        surface_match = re.search(r'([\d.]+m²)', features)
        pieces_match = re.search(r'(\d+)\s*pièces?|(\d+)\s*chambres?|(\d+)\s*salle\s*d[\'eau]*', features)
        salle_de_bain_match = re.search(r'(\d+)\s*salle\s*de\s*bain[s]*', features)
        salle_d_eau_match = re.search(r'salle\s*d[\'eau]*', features)
        chauffage_match = re.search(r'gaz|chauffage\s*central|chauffage\s*électrique|chauffage\s*au\s*fioul|chauffage\s*au\s*sol|pompe\s*à\s*chaleur|géothermie', features)
        cave_match = re.search(r'Cave', features, flags=re.IGNORECASE)
        ascenseur_match = re.search(r'Ascenseur', features, flags=re.IGNORECASE)
        balcon_match = re.search(r'Balcon', features, flags=re.IGNORECASE)
        box_match = re.search(r'Box', features, flags=re.IGNORECASE)
        digicode_match = re.search(r'Digicode', features, flags=re.IGNORECASE)
        gardien_match = re.search(r'Gardien', features, flags=re.IGNORECASE)
        exposition_match = re.search(r'Nord(-Est|-Ouest)?|Sud(-Est|-Ouest)?|Est|Ouest', features)
        interphone_match = re.search(r'Interphone', features, flags=re.IGNORECASE)
        garage_match = re.search(r'Garage', features, flags=re.IGNORECASE)
        parking_match = re.search(r'Parking', features, flags=re.IGNORECASE)
        cheminee_match = re.search(r'Cheminée', features, flags=re.IGNORECASE)
        alarme_match = re.search(r'Alarme', features, flags=re.IGNORECASE)
        climatisation_match = re.search(r'Climatisation', features, flags=re.IGNORECASE)
        dependance_match = re.search(r'Dépendance', features, flags=re.IGNORECASE)
        terrasse_match = re.search(r'Terrasse', features, flags=re.IGNORECASE)
        radiateurs_match = re.search(r'Radiateurs', features, flags=re.IGNORECASE)
        jardin_match = re.search(r'Jardin', features, flags=re.IGNORECASE)

        # Mettre à jour les colonnes en fonction des correspondances
        if surface_match:
            # Supprimer "m²" de la valeur de la surface
            df.at[index, 'Surface'] = surface_match.group(1).replace('m²', '')
        
        if pieces_match:
            df.at[index, 'Nombre de pièces'] = max(filter(None, pieces_match.groups()), key=lambda x: int(x) if x else 0)
            df.at[index, 'Nombre de chambres'] = max(filter(None, pieces_match.groups()), key=lambda x: int(x) if x else 0)
            df.at[index, 'Salles d\'eau'] = max(filter(None, pieces_match.groups()), key=lambda x: int(x) if x else 0)
        
        if salle_de_bain_match:
            df.at[index, 'Nombre de salles de bain'] = salle_de_bain_match.group(1)
        
        if salle_d_eau_match and not any(char.isdigit() for char in salle_d_eau_match.group()):
            # Si "salle d'eau" ne contient pas de chiffre, considérer comme 1
            df.at[index, 'Salles d\'eau'] = "1"
        
        if chauffage_match:
            df.at[index, 'Chauffage'] = chauffage_match.group(0)
        
        if cave_match:
            df.at[index, 'Cave'] = "Oui"
        
        if ascenseur_match:
            df.at[index, 'Ascenseur'] = "Oui"
        
        if balcon_match:
            df.at[index, 'Balcon'] = "Oui"
        
        if box_match:
            df.at[index, 'Box'] = "Oui"
        
        if digicode_match:
            df.at[index, 'Digicode'] = "Oui"
        
        if gardien_match:
            df.at[index, 'Gardien'] = "Oui"
        
        if exposition_match:
            df.at[index, 'Exposition'] = exposition_match.group(0)
        
        if interphone_match:
            df.at[index, 'Interphone'] = "Oui"
        
        if garage_match:
            df.at[index, 'Garage'] = "Oui"
        
        if parking_match:
            df.at[index, 'Parking'] = "Oui"
        
        if cheminee_match:
            df.at[index, 'Cheminée'] = "Oui"
        
        if alarme_match:
            df.at[index, 'Alarme'] = "Oui"
        
        if climatisation_match:
            df.at[index, 'Climatisation'] = "Oui"
        
        if dependance_match:
            df.at[index, 'Dépendance'] = "Oui"
        
        if terrasse_match:
            df.at[index, 'Terrasse'] = "Oui"
        
        if radiateurs_match:
            df.at[index, 'Radiateurs'] = "Oui"
        
        if jardin_match:
            df.at[index, 'Jardin'] = "Oui"

# Supprimer les espaces des nombres dans la colonne "Prix"
df['Prix'] = df['Prix'].replace({' ': ''}, regex=True)

# Enregistrez le nouveau dataframe dans un fichier CSV
df.to_csv('dataset_final.csv', index=False)
