# Vliegplezier

Lees eerst [`CLAUDE-BRIEF-vliegplezier.md`](CLAUDE-BRIEF-vliegplezier.md) (doel, besluiten, techniek) en [`docs/werkpakketten.md`](docs/werkpakketten.md).

## Werkafspraken

- YAGNI: bouw alleen wat het huidige werkpakket nodig heeft.
- Communicatie en gebruikersteksten in het Nederlands; code, commits en vertaalsleutels in het Engels. Teksten via `__()` met vertalingen in `lang/nl.json`.
- Elke wijziging heeft een Pest-test en moet `vendor/bin/pint --test` halen.

## Commando's

```sh
docker compose up -d        # lokale PostgreSQL/PostGIS
composer setup              # eerste keer: install, .env, key, migrate, assets
composer dev                # app + vite lokaal
vendor/bin/pest             # tests (standaard op SQLite in-memory)
vendor/bin/pint             # code style
```

CI (`.github/workflows/ci.yml`) draait Pint en Pest tegen PostgreSQL met PostGIS.
