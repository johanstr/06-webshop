# Module 06 - Webshop | Dev  
## Inleiding
Dit is de map waarin we met PHP een 'echte' webapplicatie gaan programmeren. In deze map zien we niet alleen de mappen **css**, **fonts**, **img** en **js** terug, zoals deze in de ***design*** map zijn te vinden.  
  
Maar ook mappen die speciaal voor het programmeren in PHP worden aangemaakt. Zoals de map **src**.  
  
In de root van de ***dev*** map plaatsen we alle PHP-bestanden die een pagina laten zien. In de map ***src*** plaatsen we alle PHP-bestanden waarin code staat die op de achtergrond allerlei taken uitvoeren ten behoeven van b.v. de pagina's.  
  
### template (speciale map)
Je ziet echter ook nog de map ***template***. In deze map plaatsen we in speciale PHP-bestanden de stukken HTML-code die voor iedere pagina in onze webapplicatie hetzelfde is.  
Zodoende krijgen we twee bestanden, namelijk:  
  
* head.inc.php  
  In dit bestand vinden we de HTML-code terug waarmee iedere pagina van onze applicatie start.  
* foot.inc.php  
  In dit bestand komt het onderste deel van de HTML-code die op iedere pagina hetzelfde is.  

Door dit te doen hoeven we deze code voor iedere pagina niet steeds opnieuw te knippen en plakken. En we maken het onszelf makkelijker wanneer we in deze code iets willen aanpassen zodat het voor iedere pagina geldt. We hoeven dit nu slechts op 1 plek te doen en automatische geldt het dan voor iedere pagina.  
  
### docker  
Mocht je met docker willen werken i.p.v. XAMPP/WAMP dan vind je in deze map de nodige Dockerfiles. Verander hier niks aan wanneer je gelijk aan de slag wil. Alles is goed ingesteld en getest.  
  
  
## Lokaal installeren met XAMPP/WAMP
Om deze voorbeeld applicatie lokaal op je computer te installeren en het werkend te krijgen voer je de onderstaande stappen uit.  
  
### Prerequisites  
Voor de onderstaande stappen gaan we ervan uit dat de volgende applicaties zijn geïnstalleerd op het lokalen systeem:  
  
* XAMPP of WAMP
* Git Bash (Terminal versie)  
  
En we gaan ervan uit dat we werken met het Windows besturingssysteem.  
  
### Stap 1 - Database aanmaken  
Met b.v. **PhpMyAdmin** gaan we de database aanmaken. We maken nog geen tabellen etc. aan. De naam van de database die gebruikt wordt in de applicatie is ***2324_wittekip***.  
  
### Stap 2 - Installeren code  
In de rootmap van de geïnstalleerde applicatie (XAMPP of WAMP b.v.) openen we de terminal (CMD, PowerShell, Git Bash) en tikken de volgende opdracht in:  
  
```bash
git clone https://github.com/johanstr/06-webshop.git
```  
  
Hiermee installeren we de gehele code van de applicatie in de map ***06-webshop***.  
  
### Stap 3 - Aanpassen Database credentials in PHP code
We passen nu de credentials aan in het volgende bestand:  
  
> **06-webshop/dev/src/Database/Database.php**  
  
Onderstaande fields in de class Database moeten we dan aanpassen:
```php
      private static $dbHost = "127.0.0.1";
      private static $dbName = "2324_wittekip";
      private static $dbUser = "root";
      private static $dbPassword = "root";
```  
  
Let op! XAMPP en WAMP vereisen geen wachtwoord voor de database user. Dus die het woord **root** haal je daar tussen de aanhalingstekens weg (niet de aanhalingstekens dus).
  
### Stap 4 - Importeren tabellen en testgegevens
We importeren nu de tabellen en de testgegevens. Daarvoor is in de map ***06-webshop*** een SQL-script beschikbaar met de naam:  
  
> **2324_wittekip.sql**  
  
### Stap 5 - [OPTIONEEL] Maak lokaal een domeinnaam aan
We kunnen voor ons gemak lokaal een domeinnaam aanmaken, daarvoor heb je twee bestanden nodig, namelijk:  
  
1. C:\Windows\System32\drivers\etc\hosts  
   Dit bestand moet wel als Administrator in een teksteditor geopend worden.  Hierin tikken onderin het bestand we het volgende in:  
     
   > ***127.0.0.1    wittekip.local***  
     
   Maar let op, als er nog niet eerder op deze manier een lokale domeinnaam is toegevoegd dan moet als eerste regel de volgende boven de net eigen gemaakte staan:  
     
   > ***127.0.0.1    localhost***  
     
   En we slaan nu het bestand op.  

2. Het tweede bestand nodig is (afhankelijk van de geïnstalleerde applicatie, XAMPP of WAMP, we nemen als voorbeeld XAMPP):  
     
   > ***c:\xampp\apache\conf\extra\httpd_vhosts.conf*** 
     
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
   
De volgende stap is dat je de Apache webserver herstart. Dit is nodig zodat de Apache webserver de zojuist aangepaste httpd_vhosts.conf configuratie file kan toepassen.  
  
Je kan nu, als alles goed gegaan is, het webadres http://wittekip.local gebruiken om je applicatie in de browser te openen/starten.  
  
## Lokaal installeren met Docker
Om deze voorbeeld applicatie lokaal op je computer te installeren en het werkend te krijgen voer je de onderstaande stappen uit.  
  
### Prerequisites  
Voor de onderstaande stappen gaan we ervan uit dat de volgende applicaties zijn geïnstalleerd op het lokalen systeem:  
  
* docker terminal app
* docker-compose terminal app
* docker-credentials-helper terminal app
* Git Bash (Terminal versie)  
* GEEN XAMPP of WAMP ACTIEF
  
De terminal apps hierboven kun je op verschillende manier installeren.  
* **Mac OSX**  
  Je kunt onder het besturingssysteem Mac OSX b.v. gebruik maken van de terminal app [***HomeBrew***](https://brew.sh/). Je moet deze wel eerst installeren uiteraard.
* **Windows**  
  Onder windows kun je b.v. gebruik maken van de terminal app [***Chocolately***](https://community.chocolatey.org/) (wel eerst installeren). Er zijn ook alternatieven beschikbaar.  
* **Linux**  
  Onder Linux kun je ook [***HomeBrew***](https://docs.brew.sh/Homebrew-on-Linux) gebruiken. Linux heeft uiteraard al een standaard terminal manier om programma's te installeren, maar als je HomeBrew makkelijker vind is dit een optie.  

In alle gevallen gaat het om zogenaamde app managers, waarmee je eenvoudig via de terminal programma's kunt installeren.  
  
### Stap 1 - Installeren code  
In een specifiek voor deze module aangemaakte projectmap openen we de terminal (CMD, PowerShell, Git Bash) en tikken de volgende opdracht in:  
  
```bash
git clone https://github.com/johanstr/06-webshop.git
```  
  
Hiermee installeren we de gehele code van de applicatie in de map ***06-webshop***.  
  
### Stap 2 - Docker container bouwen en/of starten  
#### EERSTE KEER
De containers moeten namelijk eerst gedownload en gebouwd worden.  
Open in je projectmap een terminal en ga naar de submap **dev**.  
  
Tik daar de volgende opdracht in:  
```bash
docker-compose up --build
```  
  
#### NA EERSTE KEER  
Als het goed is zijn de containers na de eerste keer al aanwezig en hoeven dus niet meer gebouwd te worden. Dus kunnen we de containers gewoon starten.  
Open in je projectmap een terminal en ga naar de submap dev.  
  
Tik daar de volgende opdracht in:  
```bash
docker-compose up
```  
  
### Stap 3 - Importeren tabellen en testgegevens
1. Open PhpMyAdmin met de volgende link: [http://localhost:8080](http://localhost:8080)  
2. Open de database **webshop**  
   
We importeren nu de tabellen en de testgegevens. Daarvoor is in de map ***06-webshop*** een SQL-script beschikbaar met de naam:  
  
> **2324_wittekip.sql**  
  
### Tot slot
Alle code staat nu zowel lokaal in je projectmap als in de container. Je kunt gewoon werken aan de lokale code. Op de achtergrond synchroniseert docker de code dan.