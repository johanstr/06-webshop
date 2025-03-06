# Module 06 - Webshop  
Als voorbeeld project wordt met jullie samen een webshop gebouwd. Let wel, het is slechts een simulatie. Dit betekent dat niet alle functionaliteit tijdens de instructies zal worden gebouwd.

Verder zijn er keuzes gemaakt in de manier van programmeren die niet aan te bevelen zijn voor een echt project, maar alleen maar gekozen zijn ten behoeve van het doel van de module.
  
## In deze module leer je:  
* De programmeertaal PHP kennen  
  Dit is één van de vele talen om webapplicaties mee te bouwen.
* Hoe je een groter project gestructureerd kunt aanpakken.  
* Hoe je met HTML, CSS, PHP en eventueel JavaScript een complete webapplicatie kunt bouwen
* ... en meer ...  
  
## Wat vind je in deze repository?  
In deze repository vind je twee mappen, namelijk:  
  
* design  
  In deze map hebben we met HTML en CSS alle pagina's al gebouwd. Dit is voorwerk, want tijdens het 'echt' programmeren willen we namelijk ons niet meer bezig hoeven houden met het ontwerpen en bouwen van de verschillende pagina's. 
* dev  
  Dit is de map waarin we met PHP de webshop ook 'echt' gaan programmeren. Oftewel alle functionaliteit voegen we toe en we gaan programmeren dat we gegevens in een database kunnen opslaan.

## Lokaal installeren
Om deze voorbeeld applicatie lokaal op je computer te installeren en het werkend te krijgen voer je de onderstaande stappen uit.  
  
### Prerequisites  
Voor de onderstaande stappen gaan we ervan uit dat de volgende applicaties zijn geïnstalleerd op het lokalen systeem:  
  
* XAMPP of WAMP
* Git Bash (Terminal versie)  
  
En we gaan ervan uit dat we werken met het Windows besturingssysteem.  
  
### Stap 1 - Database aanmaken  
Met b.v. PhpMyAdmin gaan we de database aanmaken. We maken nog geen tabellen etc. aan. De naam van de database die gebruikt wordt in de applicatie is ***2324_wittekip***.  
  
### Stap 2 - Installeren code  
In de rootmap van de geïnstalleerde applicatie (XAMPP of WAMP b.v.) openen we de terminal (CMD, PowerShell, Git Bash) en tikken de volgende opdracht in:  
  
```bash
git clone https://github.com/johanstr/06-webshop.git
```  
  
Hiermee installeren we de gehele code van de applicatie in de map ***06-webshop***.  
  
### Stap 3 - Aanpassen Database credentials in PHP code
We passen nu de credentials aan in het volgende bestand:  
  
**06-webshop/dev/src/Database/Database.php**  
  
### Stap 4 - Importeren tabellen en testgegevens
We importeren nu de tabellen en de testgegevens. Daarvoor is in de map ***06-webshop/dev*** een SQL-script beschikbaar met de naam:  
  
**2324_wittekip.sql**  
  
### Stap 5 - [OPTIONEEL] Maak lokaal een domeinnaam aan
We kunnen voor ons gemak lokaal een domeinnaam aanmaken, daarvoor heb je twee bestanden nodig, namelijk:  
  
1. C:\Windows\System32\drivers\etc\hosts  
   Dit bestand moet wel als Administrator in een teksteditor geopend worden.  Hierin tikken onderin het bestand we het volgende in:  
     
   ***127.0.0.1    wittekip.local***  
     
   Maar let op, als er nog niet eerder op deze manier een lokale domeinnaam is toegevoegd dan moet als eerste regel de volgende boven de net eigen gemaakte staan:  
     
   ***127.0.0.1    localhost***  
     
   En we slaan nu het bestand op.  

2. Het tweede bestand nodig is (afhankelijk van de geïnstalleerde applicatie, XAMPP of WAMP, we nemen als voorbeeld XAMPP):  
     
   ***c:\xampp\apache\conf\extra\httpd_vhosts.conf*** 
     
   In dit bestand voeg je onderaan het volgende toe:  
     
   ```apache
      <VirtualHost *:80>
         DocumentRoot "c:/xampp/htdocs/06-webshop/dev"
         ServerName wittekip.local
      </VirtualHost>
   ```
     
   Maar let op, als je in stap 5 ook de regel voor localhost hebt toegevoegd moet je dat ook in dit bestand doen. De onderstaande code voeg je boven je eigen domeinnaam toe:  
     
   ```apache
      <VirtualHost *:80>
         DocumentRoot "c:\xampp\htodcs"
         ServerName localhost
      </VirtualHost>
   ```