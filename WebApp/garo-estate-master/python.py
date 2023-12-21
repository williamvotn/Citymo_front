import json

def use_given_ids():
    given_ids = [39181043, 40022039, 3088314, 40378877, 42873257]
    return given_ids

# Appel de la fonction pour obtenir les IDs donnés
ids_to_use = use_given_ids()

# Conversion en JSON et impression
print(json.dumps(ids_to_use))
