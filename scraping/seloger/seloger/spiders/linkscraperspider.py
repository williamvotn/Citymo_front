import scrapy
import csv

class LinkScraperSpider(scrapy.Spider):
    name = 'link_scraper'

    def start_requests(self):
        # Charger les liens depuis le CSV
        with open('3annonces_links.csv', 'r') as file:
            reader = csv.reader(file)
            for row in reader:
                link = row[0]  # La première colonne contient les liens
                if link:
                    yield scrapy.Request(url=link, callback=self.parse)

    def parse(self, response):
        # Ajouter ici la logique pour extraire les données de la page
        # Exemple : récupérer le titre de la page
        title = response.css('title::text').get()

        # Exemple : récupérer le contenu de la page
        content = response.css('body::text').get()

        # Exemple : récupérer le prix de l'annonce
        price = response.css('span.price::text').get()

        # Ajouter d'autres logiques de récupération de données selon vos besoins

        # Écrire les résultats dans le nouveau CSV
        with open('dataset.csv', 'a', newline='', encoding='utf-8') as file:
            writer = csv.writer(file)
            # Ajouter les colonnes que vous avez extraites de la page
            writer.writerow([title, content, price, response.url])
