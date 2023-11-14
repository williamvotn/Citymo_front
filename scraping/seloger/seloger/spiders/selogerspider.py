import scrapy
import csv

class SelogerSpider(scrapy.Spider):
    name = 'seloger'
    start_urls = ['https://immobilier.lefigaro.fr/annonces/immobilier-vente-appartement-paris.html?types=maison,maison%2Bneuve&sort=6&priceMin=1280000']
    base_url = 'https://immobilier.lefigaro.fr'
    max_pages = 100  # Nombre maximal de pages à scraper

    def parse(self, response):
        # Extraire tous les liens vers les annonces dans le bloc-list-annonces
        annonce_links = response.css('.bloc-annonces .cartouche-liste__body a::attr(href)').getall()
        prices = response.css('.bloc-annonces .cartouche-liste__body .price::text').getall()

        # Enregistrer les liens et les prix dans un fichier CSV
        with open('annonces_links.csv', 'a', newline='') as csvfile:
            fieldnames = ['Annonce Link', 'Price']
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames)

            for annonce_link, price in zip(annonce_links, prices):
                full_link = self.base_url + annonce_link
                # Correction de la construction du lien
                full_link = full_link.replace('https://immobilier.lefigaro.frhttps://', 'https://')
                writer.writerow({'Annonce Link': full_link, 'Price': price.strip()})

        self.log('Annonces links and prices saved in annonces_links.csv')

        # Extraire le lien vers la page suivante
        next_page = response.css('a[rel="next"]::attr(href)').get()

        # Continuer le scraping sur la page suivante (jusqu'à max_pages)
        if next_page and response.meta.get('page_count', 1) < self.max_pages:
            yield scrapy.Request(url=self.base_url + next_page, callback=self.parse, meta={'page_count': response.meta.get('page_count', 1) + 1})
