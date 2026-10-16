# Kostenoverzicht infrastructuur (fase 1)

Stand 16-10-2026. Bedragen per maand, excl. btw. Prijzen met een * zijn niet actueel geverifieerd en moeten vóór de keuze op de site van de leverancier gecheckt worden.

## Aannames over belasting

- Schrijven (pluimen, accounts) is weinig, ook bij tienduizenden gebruikers.
- Lezen (kaart, locatiepagina's) piekt bij media-aandacht. Dit vangen we op met vooraf berekende cijfers en Cloudflare (gratis) als cache/CDN, niet met meer servers.
- Fase 2 (OGN) vraagt een continu draaiend proces. Op een VPS kost dat niets extra; bij serverless is een aparte host nodig.

## Opties

| | A. Laravel op eigen VPS, zelf beheerd | B. Laravel op eigen VPS met beheertool (Forge/Ploi) | C. Laravel Cloud (volledig beheerd) | D. Supabase + Vercel (TypeScript) |
|---|---|---|---|---|
| Hosting | Hetzner CX23 € 5,49 + back-ups ~€ 1,10 + IPv4 ~€ 0,60 ≈ **€ 7** | Hetzner ≈ € 7 | gebruiksafhankelijk, inschatting **€ 20-60*** | Supabase Pro $ 25 + Vercel Pro $ 20* ≈ **€ 42** |
| Beheertool | – | Forge vanaf ~$ 10-12 (jaarbetaling)*, Ploi vergelijkbaar* ≈ **€ 11** | inbegrepen | inbegrepen |
| Fase 2 OGN-proces | op dezelfde VPS | op dezelfde VPS | worker, meerprijs* | aparte VPS ≈ € 6 |
| **Totaal / maand** | **≈ € 7** | **≈ € 18** | **≈ € 20-60** | **≈ € 42-48** |
| Opzet (eenmalig) | 6-10 uur: provisioning, webserver, PHP, database, SSL, back-ups, firewall, monitoring | 2-3 uur: server koppelen, deploy instellen | 1-2 uur | 3-5 uur, plus zelf auth/beheer bouwen |
| Beheer (doorlopend) | **1-3 uur/mnd**: OS- en PHP-updates, back-up-checks, certificaten, storingen. Jij bent de pager. | **0,5-1 uur/mnd**: tool regelt deploys, SSL, security-updates; OS-upgrades en storingen blijven bij jou | **~0** | **~0** |
| Lock-in | geen | laag (server blijft van jou) | middel | hoog (auth, database-API) |
| Data in EU | ja (Duitsland/Finland) | ja | EU-regio kiesbaar, Amerikaanse aanbieder | EU-regio kiesbaar, Amerikaanse aanbieders |

Vaste posten die bij alle opties gelijk zijn: domein vliegplezier.nl, Laposta, transactionele e-mail (verificatie- en wachtwoordmails; gratis tier van bijv. Brevo is genoeg voor de start, daarna ~€ 15*), Cloudflare (gratis).

## Totale kosten inclusief eigen tijd

Bij een tijdwaarde van € 50/uur, eerste jaar:

| | Hosting + tool | Opzet | Beheer | **Totaal jaar 1** |
|---|---|---|---|---|
| A. Zelf beheerd | € 84 | € 400 | € 1.200 (2 u/mnd) | **≈ € 1.700** |
| B. Met Forge/Ploi | € 216 | € 125 | € 450 (0,75 u/mnd) | **≈ € 790** |
| C. Laravel Cloud | € 240-720 | € 75 | € 0 | **≈ € 300-800** |
| D. Supabase + Vercel | € 550 | € 200 + bouwwerk auth/beheer | € 0 | **≈ € 750 + bouwwerk** |

## Advies

**B: Laravel op een eigen Hetzner-VPS met Forge of Ploi.** Laagste totaalkosten zonder lock-in, fase 2 draait gratis mee, en je houdt de data in de EU. Als het project financiering krijgt en beheertijd het knelpunt wordt, kan dezelfde Laravel-app zonder herbouw naar Laravel Cloud (C).

## Bronnen

- [Hetzner-prijsverhoging juni 2026 (privatedevops.com)](https://privatedevops.com/news/hetzner-june-2026-cloud-price-increase-what-to-do)
- [Laravel-plannen (pricingsaas.com)](https://pricingsaas.com/companies/laravel)
- [Supabase-prijzen 2026 (makerkit.dev)](https://makerkit.dev/blog/md/saas/supabase-pricing)
