from sqlalchemy import create_engine
from sqlalchemy.exc import SQLAlchemyError

# Informations du conteneur Docker
container_info = {
    "HostConfig": {
        "PortBindings": {
            "3306/tcp": [
                {
                    "HostIp": "0.0.0.0",
                    "HostPort": "5000"
                }
            ]
        }
    }
}

# Configuration de la connexion
db_config = {
    'user': 'root',
    'password': 'root',
    'host': 'localhost',  # Utilisation de l'alias pour l'hôte Docker sur Windows/macOS
    'port': container_info['HostConfig']['PortBindings']['3306/tcp'][0]['HostPort'],
    'database': 'siteimmo',
    'drivername': 'mysql+pymysql',
}

# Créer une instance de moteur SQLAlchemy
engine = create_engine(f"{db_config['drivername']}://{db_config['user']}:{db_config['password']}@{db_config['host']}:{db_config['port']}/{db_config['database']}")

# Définir la variable de connexion en dehors du bloc try
connection = None

# Tentative de connexion à la base de données
try:
    connection = engine.connect()
    print(f"Connecté à la base de données sur le port {db_config['port']}")

except SQLAlchemyError as e:
    print(f"Erreur de connexion à la base de données : {e}")

finally:
    # Fermer la connexion à la base de données
    if connection and connection.closed == 0:
        connection.close()
        print("Connexion à la base de données fermée.")
