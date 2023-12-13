import pandas as pd

# Lire le fichier CSV
df = pd.read_csv('dataset/paris.csv')

# Nom de la table SQL
table_name = 'paris'

# Générer le script SQL
sql_script = f"CREATE TABLE {table_name} (\n"

# Ajouter les colonnes avec les types correspondants
for column in df.columns:
    if df[column].dtype == 'int64':
        sql_script += f"    {column} INT,\n"
    elif df[column].dtype == 'float64':
        sql_script += f"    {column} DECIMAL(9,2),\n"
    elif df[column].dtype == 'bool':
        sql_script += f"    {column} BOOLEAN,\n"
    else:
        sql_script += f"    {column} VARCHAR(255),\n"

# Ajouter la clé primaire
sql_script += f"    PRIMARY KEY (ID)\n"

# Fermer la création de la table
sql_script += ");"

# Enregistrer le script SQL dans un fichier
with open('dataset/paris.sql', 'w') as f:
    f.write(sql_script)

print(f"Le script SQL a été enregistré dans le fichier 'paris.sql'.")
