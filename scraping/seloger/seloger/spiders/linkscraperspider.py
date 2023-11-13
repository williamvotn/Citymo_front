import scrapy
import csv

class LinkScraperSpider(scrapy.Spider):
    name = 'link_scraper'

    def start_requests(self):
        # Charger les liens depuis le CSV
        with open('3annonces_links.csv', 'r') as file:
            reader = csv.reader(file)
            # Ignorer la première ligne du CSV (entête)
            next(reader, None)
            for row in reader:
                link = row[0]  # La première colonne contient les liens
                price = row[1]  # La deuxième colonne contient les prix
                if link:
                    yield scrapy.Request(url=link, meta={'price': price}, callback=self.parse)

    def parse(self, response):
        # Extraire l'ID de l'appartement du lien
        apartment_id = response.url.split('-')[-1].split('.')[0]

        # Extraire le lien de l'image
        image_url = response.css('div.grid-3 a.classified-medias__picture picture img::attr(src)').get()
        # Si le sélecteur initial ne renvoie aucun résultat, chercher dans 'grid-2' puis 'grid-1'
        if not image_url:
            image_url = response.css('div.grid-2 a.classified-medias__picture picture img::attr(src)').get()
            if not image_url:
                # Changer le sélecteur pour rechercher dans <classified-medias grid-no> <picture data-v-57a34d75> <img::attr(src)>
                image_url = response.css('section.classified-medias.grid-no img::attr(src)').get()

        # Récupérer le prix depuis les méta-données
        price = response.meta.get('price', '')

        # Écrire les résultats dans le nouveau CSV
        with open('dataset.csv', 'a', newline='', encoding='utf-8') as file:
            writer = csv.writer(file)

            # Si le fichier est vide, écrire l'entête
            if file.tell() == 0:
                writer.writerow(['ID', 'Link', 'ImageURL', 'Price'])

            # Ajouter les colonnes extraites de la page
            writer.writerow([apartment_id, response.url, image_url, price])
