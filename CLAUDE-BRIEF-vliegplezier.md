# Claude Code-brief: Vliegplezier (vliegplezier.nl)

Startdocument voor iedereen (mens of Claude) die aan Vliegplezier bouwt. Werkpakketten staan in [`docs/werkpakketten.md`](docs/werkpakketten.md).

## 1. Doel

Vliegplezier levert **controleerbare cijfers** over hoeveel mensen per vlieglocatie plezier beleven en waar ze vandaan komen. Clubs en de KNVvL gebruiken die cijfers richting **beslissers** (gemeenten, provincies, Rijk) als tegenwicht tegen klagers, in discussies over geluid, milieu, natuur, ruimte, (mentale) gezondheid en vrijetijdsbesteding.

Daaruit volgen drie toetsvragen voor elke feature:

1. **Maakt het de cijfers geloofwaardiger?** De eerste tegenwerping van klagers is "die pluimen zijn nep". Betrouwbaarheid weegt het zwaarst.
2. **Helpt het een club de cijfers bij een beslisser te krijgen?** Denk aan een deelbare locatiepagina en open data.
3. **Verlaagt het de drempel om een pluim te geven?** Zonder volume zeggen de cijfers niets.

Draagt een feature aan geen van de drie bij, dan wacht hij (YAGNI).

## 2. Kernbegrip: de pluim

- Een pluim is: één geverifieerd persoon, één vlieglocatie, één luchtsport, één datum.
- Maximaal één pluim per persoon per locatie per luchtsport per dag (unieke index in de database).
- De datum mag tot 7 dagen terug liggen. Binnen die 7 dagen kan de gever zijn pluim verwijderen; aanpassen gaat via verwijderen en opnieuw geven.
- Bij elke pluim wordt de herkomst (postcode-4 van de gever op dat moment) vastgelegd, plus een IP-hash als fraude-indicator.

### Unieke gevers

- Eén persoon is één geverifieerd account. E-mailadressen worden genormaliseerd (o.a. Gmail-punten en +-aliassen) en wegwerpdomeinen worden geweigerd.
- **Gever-ID:** elk account heeft een vast, willekeurig pseudoniem (bijv. `g-7f3a9c`), los van account-ID en e-mail.
- **Netwerk-ID:** het IP-adres wordt alleen als keyed hash (HMAC met geheime sleutel) opgeslagen; in de export staat per pluim een pseudoniem daarvan. Dit is een signaal, geen bewijs: huishoudens en clubhuis-wifi delen één IP.
- Admins zien clusters van accounts per netwerk-ID en kunnen pluimen afkeuren; afgekeurde pluimen tellen nergens mee.

## 3. Besluiten

| Onderwerp | Besluit | Bron |
|---|---|---|
| Architectuur | Eén Laravel-app, niet headless. Pagina's en REST API in dezelfde codebase en deploy. De kaart is een JS-component. Splitsen pas als de native apps er echt komen. | projectinstructies |
| Fase 1 | Responsive webapp met REST API. Native apps en social login later. | projectinstructies |
| Verificatie | Alleen e-mailverificatie, met blokkade van wegwerp-e-maildomeinen en een IP-hash als fraude-indicator. Sms-verificatie van het telefoonnummer komt pas als het project een bepaalde status en financiering heeft. | Frank, 16-10-2026 |
| Gebruikersnaam | Nooit publiek. Publieke data is geaggregeerd of pseudoniem. | projectinstructies |
| Postcode | Alleen postcode-4, maximaal één keer per 3 maanden aan te passen. | concept Frank |
| Rollen | Gebruiker en globale admin. Geen locatiebeheerders in fase 1. | projectinstructies |
| Vlieglocaties | Alleen admins beheren ze, met een vaste lijst luchtsporten per locatie. Eenmalig gevuld uit de AIP Netherlands (velden, lierlocaties en dropzones uit ENR 5.5). Paraglidinglocaties voegt een admin met de hand toe. Geen aanmeldformulier voor bezoekers. | projectinstructies |
| Luchtvaartdata | Alleen VFR. Bron is de AIP Netherlands (velden, frequenties, telefoonnummers; per locatie kunnen het er meer zijn). | projectinstructies |
| Privacy op de kaart | Herkomst wordt op postcode-4 getoond zonder minimumaantal; postcode-4 geldt als anoniem genoeg. | Frank, 16-10-2026 |
| Open data | Export en API alleen met een gratis account (API-key per account). CSV-export per pluim: datum, locatie, luchtsport, postcode-4, gever-ID, netwerk-ID. Geen gebruikersnaam of IP. Licentie CC BY 4.0. | Frank, 16-10-2026 |
| Taal | Nederlandse teksten via Laravel-vertaalbestanden. Code en techniek in het Engels. | projectinstructies |
| Nieuwsbrief | Aanmelden via Laposta (API). | projectinstructies |
| Foto bij pluim | Alleen na opt-in, met EXIF-validatie en goedkeuring door een admin. Pas in fase 2. | projectinstructies, fasering *aanname* |
| Actieve locaties | Fase 2, als bijvangst. Bronnen: primair OGN/GlideNet, aangevuld met ADS-B (Flightradar24 of vergelijkbaar). | Frank, 16-10-2026 |
| Locatiepagina | Fase 1: publieke pagina per locatie met kerncijfers, filterbaar op luchtsport, locatie, tijdspanne en herkomst (gemeente, provincie, instelbare straal). Kaart gebruikt dezelfde filters. | Frank, 16-10-2026 |
| Hosting | Hetzner VPS. Frank voert het provisioning-script zelf uit. | projectinstructies |

## 4. Techniek

Gekozen op 16-10-2026: route B uit [`docs/kosten-infrastructuur.md`](docs/kosten-infrastructuur.md), Laravel op een eigen Hetzner-VPS met een beheertool (Forge of Ploi). Een latere overstap naar Laravel Cloud kan zonder herbouw.


- **Backend:** Laravel 12, PHP 8.3+, PostgreSQL met PostGIS (herkomst- en straalfilters).
- **Frontend:** Blade + Livewire + Alpine. Kaart met MapLibre GL JS (vector, goed voor ~4.000 postcode-4-vlakken).
- **Admin:** Filament, zodat het beheer niet zelf gebouwd hoeft te worden.
- **Geodata:** CBS/PDOK postcode-4-vlakken (vereenvoudigd) en de koppeling postcode-4 naar gemeente en provincie.
- **Tests en kwaliteit:** Pest, Laravel Pint, GitHub Actions.
- **Hosting en deploy:** Hetzner-VPS (Duitsland/Finland), beheerd via Forge of Ploi (keuze in WP0). Cloudflare als cache/CDN. Frank richt de server en de beheertool in; Claude levert de deploy-configuratie.
- **Fase 2:** het OGN-proces draait als apart, langlopend proces op dezelfde VPS.

## 5. Buiten scope van fase 1

Sms-verificatie, native apps, social login, locatiebeheerders, aanmeldformulier voor nieuwe vlieglocaties, foto's bij pluimen, XLSX-export (CSV opent ook in Excel), meertaligheid en de pagina "Actieve locaties" (OGN/ADS-B). Die laatste staat als fase 2 in de werkpakketten.

## 6. Open punten

Geen. Nieuwe besluiten worden in §3 en §4 bijgeschreven met datum.
