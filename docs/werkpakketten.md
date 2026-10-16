# Werkpakketten Vliegplezier

Afgeleid van [`CLAUDE-BRIEF-vliegplezier.md`](../CLAUDE-BRIEF-vliegplezier.md). Volgens YAGNI: elk pakket levert iets werkends op en bouwt alleen wat de volgende stap nodig heeft. Volgorde is ook de bouwvolgorde, tenzij anders vermeld.

## Fase 1: de pluim-kern

### WP0 Fundament
- Laravel-project, Git-inrichting, lokale omgeving (Sail/Docker), CI met Pint en Pest.
- Basislayout (header, footer, mobiel menu) en Nederlandse vertaalbestanden.
- Keuze Forge of Ploi; Frank richt de Hetzner-VPS en de beheertool in, Claude levert de deploy-configuratie. Cloudflare ervoor.
- **Klaar als:** een lege pagina op een testdomein draait via CI-gecontroleerde code.
- *Uit de takenlijst:* "Opzetten omgeving" en het deel "algemene opzet thema".

### WP1 Vlieglocaties en luchtsporten
- Datamodel: locatie (naam, ICAO-code indien aanwezig, coördinaten, type), luchtsporten per locatie, frequenties (0..n), telefoonnummers (0..n).
- Locatielijst samen met Frank opstellen uit de AIP Netherlands: alle officiële VFR-velden (AD 2) plus lierlocaties en dropzones (ENR 5.5). Vastleggen als gecontroleerde seed-data in de repo.
- Admin (Filament): locaties en luchtsporten beheren, paraglidinglocaties met de hand toevoegen.
- Organisaties (club, school, bedrijf) per locatie, met hun luchtsporten. Beheer door admins. Op één locatie kunnen meerdere organisaties actief zijn.
- **Klaar als:** alle Nederlandse VFR-locaties met hun luchtsporten in de database staan en een admin ze kan aanpassen.
- *Uit de takenlijst:* "Beheer aanmaken vlieglocaties + activiteiten", maar dan alleen voor admins.

### WP2 Account en verificatie
- Registreren met e-mail en wachtwoord, e-mailverificatie, wachtwoord vergeten.
- E-mailadressen normaliseren (Gmail-punten, +-aliassen) en wegwerpdomeinen weigeren (open blocklist).
- Elk account krijgt een vast pseudoniem (gever-ID).
- Profiel: postcode-4 (max. 1x per 3 maanden wijzigen), standaard vlieglocatie en standaard luchtsport.
- Account verwijderen (AVG). Pluimen blijven dan geanonimiseerd bestaan.
- **Klaar als:** een bezoeker een geverifieerd account kan aanmaken en beheren.
- *Uit de takenlijst:* "Inlog mogelijkheid", zonder de beheerdersrol.

### WP3 Pluim geven
- Formulier op een losse pagina, vooringevuld met standaardlocatie, standaardsport en vandaag.
- Voorinvullen via URL-parameters (locatie, sport, organisatie), zodat kaart en QR-code ernaar kunnen linken.
- Optioneel veld organisatie bij de pluim, vooringevuld via de QR-code van die organisatie.
- Regels: één pluim per persoon/locatie/sport/dag, datum tot 7 dagen terug, IP als keyed hash opslaan (bron netwerk-ID), herkomst-PC4 vastleggen.
- "Mijn pluimen": eigen pluimen inzien en binnen 7 dagen verwijderen.
- Printbare QR-code per locatie en per organisatie (club, school, bedrijf), voor iedereen te downloaden vanaf de publieke locatiepagina.
- **Klaar als:** een geverifieerde gebruiker op het veld via een QR-code in twee tikken een pluim geeft.
- *Uit de takenlijst:* "Formulier pluim toevoegen".

### WP4 Kaart
- Kaart met alle vlieglocaties; klik op een locatie toont naam, luchtsporten en een knop "Geef een pluim".
- Herkomstlaag (postcode-4-vlakken), standaard uit, aan te zetten door de bezoeker.
- Filters: vlieglocatie, luchtsport, datumbereik en herkomst (gemeente, provincie, instelbare straal rond de locatie). Dezelfde filterlogica als de locatiepagina (WP5).
- **Klaar als:** een bezoeker zonder account ziet waar de mensen vandaan komen die op een gekozen veld vliegen.
- *Uit de takenlijst:* "Basis kaart weergave", "Kaart weergaves pluimen" en "Kaart filter opties", zonder straatfilter.

### WP5 Locatiepagina met kerncijfers
- Publieke, deelbare pagina per vlieglocatie: aantal pluimen, aantal unieke personen, verdeling per luchtsport, per maand en per herkomstgemeente, plus een kaartje met de herkomst.
- Bedoeld om een club een link of print te laten meenemen naar een gesprek met de gemeente.
- Filters: luchtsport, locatie (één of meer), organisatie, tijdspanne en herkomst (gemeente, provincie, instelbare straal rond de locatie). Gefilterde weergave heeft een eigen deelbare URL.
- **Klaar als:** een club voor zijn veld een pagina kan delen met cijfers over een gekozen periode.
- *Nieuw ten opzichte van de takenlijst.*

### WP6 Open data en API
- CSV-export van gefilterde pluimen: datum, locatie, luchtsport, herkomst-PC4, gever-ID, netwerk-ID. Geen gebruikersnaam, geen IP. Afgekeurde pluimen niet.
- REST API (alleen-lezen) voor locaties en geaggregeerde cijfers, met een API-key per account.
- Korte API-documentatie en licentie (CC BY 4.0).
- **Klaar als:** een ingelogde gebruiker de data kan downloaden en via de API kan opvragen.
- *Uit de takenlijst:* "Export optie gegevens".

### WP7 Beheer en fraudecontrole
- Admin: alle pluimen inzien en filteren, gebruikers beheren (blokkeren).
- Signalering: clusters van accounts op hetzelfde netwerk-ID, pieken bij één locatie op één dag.
- Pluimen en accounts als verdacht markeren of verwijderen; gemarkeerde pluimen tellen niet mee in de cijfers.
- **Klaar als:** een admin verdachte patronen ziet en kan ingrijpen.
- *Uit de takenlijst:* "Pluimen inzien (beheerders)", voor admins.

### WP8 Lancering
- Privacyverklaring en gebruiksvoorwaarden, contactpagina.
- Nieuwsbriefaanmelding via Laposta.
- Verwerkersovereenkomsten (Laposta), back-ups, monitoring.
- Productie-deploy op vliegplezier.nl.
- **Klaar als:** vliegplezier.nl live is en clubs uitgenodigd kunnen worden.

## Fase 2: na de lancering, op volgorde van waarde voor het doel

- **WP9 Actieve locaties (OGN/GlideNet, primaire bron):** live kaart en historie van actieve velden, lierstartdetectie, jumpplane- en dropdetectie, frequenties en telefoonnummers per actieve locatie. Objectieve activiteit naast de pluimen.
- **WP10 Actieve locaties (ADS-B, Flightradar24 of vergelijkbaar):** aanvullende bron voor motorvliegtuigen en jumpplanes.
- **WP11 Sms-verificatie:** zodra het project status en financiering heeft. Telefoonnummer alleen als HMAC-hash, uniek per account.
- **WP12 Foto bij pluim:** opt-in, EXIF-validatie, goedkeuring door een admin.
- Daarna, alleen als er vraag naar is: locatiebeheerders, aanmeldformulier voor nieuwe locaties, XLSX-export, social login, native apps.
