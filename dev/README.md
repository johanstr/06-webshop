# Module 06 - Webshop | Dev  
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