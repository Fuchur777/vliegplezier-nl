# Vliegplezier

Platform op [vliegplezier.nl](https://vliegplezier.nl) dat laat zien hoeveel mensen plezier beleven aan recreatieve luchtvaart, per vlieglocatie en naar herkomst.

- Plan en besluiten: [`CLAUDE-BRIEF-vliegplezier.md`](CLAUDE-BRIEF-vliegplezier.md)
- Werkpakketten: [`docs/werkpakketten.md`](docs/werkpakketten.md)
- Deploy: [`docs/deploy.md`](docs/deploy.md)

## Lokaal draaien

Vereist PHP 8.3+, Composer, Node 22 en Docker.

```sh
docker compose up -d
composer setup
composer dev
```

De app draait dan op http://localhost:8000.
