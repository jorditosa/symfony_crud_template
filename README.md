# Symfony CRUD Template

Aquest és un projecte plantilla de Symfony per a aplicacions CRUD amb base de dades.

## Requisits previs

Abans de començar, assegura't de tenir instal·lat:

- [Docker](https://www.docker.com/) i Docker Compose
- [Symfony CLI](https://symfony.com/download)
- PHP 8.1 o superior
- Composer

## Instal·lació

1. Clona el repositori:
```bash
git clone <url-del-repositori>
cd symfony-crud-template
```

2. Instal·la les dependències:
```bash
composer install
```

3. Configura les variables d'entorn:
```bash
cp .env .env.local
```

Edita el fitxer `.env.local` amb la teva configuració de base de dades.

## Arrancar l'aplicació

### 1. Iniciar la base de dades

Primer, arranca els contenidors de Docker (base de dades):

```bash
docker compose up -d
```

Això iniciarà la base de dades en segon pla. Pots verificar que els contenidors estan funcionant amb:

```bash
docker compose ps
```

### 2. Crear l'esquema de la base de dades

Executa les migracions per crear l'estructura de la base de dades:

```bash
php bin/console doctrine:migrations:migrate
```

O si és la primera vegada i no tens migracions:

```bash
php bin/console doctrine:schema:create
```

### 3. Iniciar el servidor de Symfony

Arranca el servidor de desenvolupament de Symfony:

```bash
symfony serve
```

O si prefereixes especificar el port:

```bash
symfony serve -d --port=8000
```

L'aplicació estarà disponible a: `https://localhost:8000`

## Comandos útils

### Base de dades

```bash
# Crear una migració
php bin/console make:migration

# Executar migracions pendents
php bin/console doctrine:migrations:migrate

# Carregar dades de prova (fixtures)
php bin/console doctrine:fixtures:load
```

### Generar codi CRUD

```bash
# Crear una entitat
php bin/console make:entity

# Generar un CRUD complet
php bin/console make:crud
```

### Docker

```bash
# Aturar els contenidors
docker compose stop

# Aturar i eliminar els contenidors
docker compose down

# Veure els logs
docker compose logs -f
```

### Symfony CLI

```bash
# Aturar el servidor
symfony server:stop

# Veure l'estat del servidor
symfony server:status

# Executar comandes de consola
symfony console <comando>
```

## Estructura del projecte

```
.
├── config/          # Configuració de l'aplicació
├── migrations/      # Migracions de base de dades
├── public/          # Punt d'entrada i arxius públics
├── src/             # Codi font de l'aplicació
│   ├── Controller/  # Controladors
│   ├── Entity/      # Entitats de Doctrine
│   ├── Form/        # Formularis
│   └── Repository/  # Repositoris
├── templates/       # Plantilles Twig
├── var/             # Arxius generats (cache, logs)
└── docker-compose.yml
```

## Problemes comuns

### El port 8000 ja està en ús

Si el port 8000 ja està ocupat, pots especificar un altre port:

```bash
symfony serve --port=8001
```

### Error de connexió a la base de dades

Assegura't que els contenidors de Docker estan funcionant i que la configuració a `.env.local` és correcta.

### Netejar la cache

Si trobes comportaments estranys, prova a netejar la cache:

```bash
php bin/console cache:clear
```

## Desenvolupament

### Tests

```bash
# Executar tots els tests
php bin/phpunit

# Executar tests específics
php bin/phpunit tests/Controller/
```

### Anàlisi de codi

```bash
# PHPStan
vendor/bin/phpstan analyse src

# PHP CS Fixer
vendor/bin/php-cs-fixer fix
```

## Producció

Per a desplegar en producció:

1. Configura les variables d'entorn de producció
2. Instal·la les dependències sense dev:
```bash
composer install --no-dev --optimize-autoloader
```

3. Neteja i escalfa la cache:
```bash
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

4. Executa les migracions:
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

## Llicència

[MIT](LICENSE)

## Contribucions

Les contribucions són benvingudes! Si us plau, obre un issue o pull request.