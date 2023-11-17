import scrapy
import csv
import re

class LinkScraperSpider(scrapy.Spider):
    name = 'link_scraper'

    def start_requests(self):
        # Charger les liens depuis le CSV
        with open('annonces_links.csv', 'r') as file:
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
        if response.css('div.grid-3'):
            images_url = response.css('div.grid-3 a.classified-medias__picture picture img::attr(src)').getall()

        elif response.css('div.grid-2'):
            images_url = response.css('div.grid-2 a.classified-medias__picture img::attr(src)').getall()
                
        else :
            images_url = response.css('section.classified-medias.grid-no img::attr(src)').getall()

        # Récupération de l'arridissement ****** ** * * (75013) *** *
        #                                                ^^^^^
        arrondissement = re.search(r'\((.*?)\)', response.xpath('//title/text()').get()).group(1)

        # Récupérer le prix depuis les méta-données
        price = response.meta.get('price', '')

        # Récupérer les caractéristiques depuis les balises <li> et <span class="feature">
        features_list = response.css('ul.unstyled.features-list li::text').getall()
        span_features = response.css('div.popin-body ul.unstyled.features-list span.feature::text').getall()
        
        # Concaténer toutes les caractéristiques en une seule chaîne
        all_features = ', '.join(span_features + features_list)


        # Récupération de la classe de performance énergétique 
        isolation_class = response.css('div.container-dpe p.pointer::text').get()
        if not isolation_class:
            isolation_class = "Non communiqué"

        # Récupération de la classe d'émission à effet de serre 
        ecologic_class = response.css('div.container-ges p.pointer::text').get()
        if not ecologic_class:
            ecologic_class = "Non communiqué"

        # Récupération de la description
        description = response.css('p.truncated-description span::text').get()
        description = description.replace('\n', '')

        
        # Écrire les résultats dans le nouveau CSV
        with open('dataset.csv', 'a', newline='', encoding='utf-8') as file:
            writer = csv.writer(file)

            # Si le fichier est vide, écrire l'entête
            if file.tell() == 0:
                writer.writerow(['ID', 'Lien source', 'ImageURL', 'Prix', 'Arondissement', 'Features', 'Classe de performance énergétique' ,'Classe d\'émission à effet de serre', 'Description'])

            # Ajouter les colonnes extraites de la page
            writer.writerow([apartment_id, response.url, images_url, price, arrondissement, all_features, isolation_class, ecologic_class, description])
