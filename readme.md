# 🚀 TaskManager Pro

Un'applicazione completa per la gestione di progetti e task costruita con Laravel. Permette di organizzare team, assegnare compiti, tracciare progressi e collaborare in tempo reale.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📋 Indice

- [Caratteristiche](#-caratteristiche)
- [Demo](#-demo)
- [Screenshot](#-screenshot)
- [Requisiti](#-requisiti)
- [Installazione](#-installazione)
- [Configurazione](#️-configurazione)
- [Utilizzo](#-utilizzo)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Troubleshooting](#-troubleshooting)
- [Contribuire](#-contribuire)
- [Licenza](#-licenza)
- [Contatti](#-contatti)

---

## ✨ Caratteristiche

### 🔐 Autenticazione & Autorizzazione
- Sistema di registrazione e login completo
- Autenticazione tramite Laravel Sanctum
- Gestione ruoli e permessi (Admin, Manager, User)
- Reset password via email
- Autenticazione a due fattori (2FA)

### 📊 Gestione Progetti
- Creazione e gestione di progetti multipli
- Dashboard con statistiche in tempo reale
- Timeline dei progetti con milestone
- Assegnazione membri del team
- Sistema di priorità e deadline

### ✅ Task Management
- Creazione, modifica ed eliminazione task
- Stati personalizzabili (To Do, In Progress, Done, Archived)
- Sistema di etichette e categorie
- Commenti e allegati sui task
- Notifiche push per aggiornamenti

### 👥 Collaborazione
- Chat in tempo reale tra membri del team
- Sistema di notifiche email
- Menzioni utenti (@username)
- Activity log dettagliato
- Calendario condiviso

### 📈 Report & Analytics
- Dashboard con grafici interattivi
- Export dati in PDF/Excel
- Statistiche di produttività
- Time tracking per task
- Report personalizzabili

### 🎨 UI/UX
- Interface responsive (mobile-first)
- Tema scuro/chiaro
- Drag & drop per riordinare task
- Ricerca avanzata con filtri
- Supporto multilingua (IT, EN, ES)

---

## 🌐 Demo

Prova l'applicazione live: [https://taskmanager-pro-demo.com](https://taskmanager-pro-demo.com)

**Credenziali di test:**
- **Admin:** admin@taskmanager.com / Admin123!
- **Manager:** manager@taskmanager.com / Manager123!
- **User:** user@taskmanager.com / User123!

---

## 📸 Screenshot

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Gestione Task
![Tasks](docs/screenshots/tasks.png)

### Kanban Board
![Kanban](docs/screenshots/kanban.png)

---

## 📋 Requisiti

### Requisiti di Sistema
- **PHP:** >= 8.2
- **Composer:** >= 2.5
- **Node.js:** >= 18.x
- **NPM/Yarn:** ultima versione stabile

### Database Supportati
- MySQL >= 8.0
- PostgreSQL >= 13
- SQLite >= 3.35

### Estensioni PHP Richieste
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo
- GD (per manipolazione immagini)

### Software Opzionali
- Redis (per cache e code)
- Supervisor (per gestione code in produzione)
- Nginx/Apache

---

## 🚀 Installazione

### 1️⃣ Clona il Repository

```bash
git clone https://github.com/tuousername/taskmanager-pro.git
cd taskmanager-pro
```

### 2️⃣ Installa le Dipendenze PHP

```bash
composer install
```

### 3️⃣ Installa le Dipendenze JavaScript

```bash
npm install
# oppure con yarn
yarn install
```

### 4️⃣ Configura l'Ambiente

```bash
# Copia il file di configurazione
cp .env.example .env

# Genera la chiave dell'applicazione
php artisan key:generate
```

### 5️⃣ Configura il Database

Modifica il file `.env` con le tue credenziali:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskmanager_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6️⃣ Esegui le Migrazioni e i Seeder

```bash
# Esegui le migrazioni
php artisan migrate

# Popola il database con dati di esempio
php artisan db:seed

# Oppure tutto insieme
php artisan migrate:fresh --seed
```

### 7️⃣ Crea il Link Simbolico per Storage

```bash
php artisan storage:link
```

### 8️⃣ Compila gli Asset Frontend

```bash
# Sviluppo
npm run dev

# Produzione
npm run build

# Watch mode (auto-reload)
npm run watch
```

### 9️⃣ Avvia il Server di Sviluppo

```bash
php artisan serve
```

L'applicazione sarà disponibile su: **http://localhost:8000**

---

## ⚙️ Configurazione

### Configurazione Mail

Configura il servizio email nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@taskmanager.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Configurazione Redis (Opzionale ma Consigliato)

```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

### Configurazione Broadcasting (per Real-time)

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=eu
```

### File System e Storage

```env
FILESYSTEM_DISK=local

# Per S3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=eu-west-1
AWS_BUCKET=your_bucket
```

### Ottimizzazione per Produzione

```bash
# Cache delle configurazioni
php artisan config:cache

# Cache delle route
php artisan route:cache

# Cache delle view
php artisan view:cache

# Ottimizza autoload
composer install --optimize-autoloader --no-dev

# Pulisci tutte le cache
php artisan optimize:clear
```

---

## 📖 Utilizzo

### Accesso all'Applicazione

Dopo l'installazione e il seeding, puoi accedere con:

| Ruolo | Email | Password |
|-------|-------|----------|
| **Amministratore** | admin@taskmanager.com | password |
| **Manager** | manager@taskmanager.com | password |
| **Utente** | user@taskmanager.com | password |

> ⚠️ **Importante:** Cambia queste password in produzione!

### Creazione di un Nuovo Progetto

1. Accedi alla dashboard
2. Clicca su "Nuovo Progetto" nel menu laterale
3. Compila i campi richiesti:
   - Nome progetto
   - Descrizione
   - Data inizio/fine
   - Membri del team
4. Clicca su "Crea Progetto"

### Gestione Task

#### Creare un Task
```bash
# Da CLI (utile per testing)
php artisan task:create "Nome del task" --project=1 --assignee=2
```

#### Stati dei Task
- **To Do:** Task da fare
- **In Progress:** In lavorazione
- **In Review:** In revisione
- **Done:** Completato
- **Archived:** Archiviato

### Comandi Artisan Personalizzati

```bash
# Invia report giornaliero via email
php artisan report:daily

# Pulisci task archiviati più vecchi di 90 giorni
php artisan task:cleanup --days=90

# Genera statistiche mensili
php artisan stats:generate --month=10 --year=2024

# Esporta progetto in JSON
php artisan project:export 1 --format=json
```

### Gestione Code (Queue)

```bash
# Avvia worker per le code
php artisan queue:work

# Con retry e timeout
php artisan queue:work --tries=3 --timeout=60

# Monitora code fallite
php artisan queue:failed

# Riprova job falliti
php artisan queue:retry all
```

---

## 🔌 API Documentation

L'applicazione fornisce una RESTful API completa.

### Autenticazione

Tutte le richieste API richiedono un token Bearer:

```http
Authorization: Bearer {your-token}
```

#### Login
```http
POST /api/v1/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "token": "1|AbCdEf...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

### Endpoints Principali

#### Progetti
```http
GET    /api/v1/projects          # Lista progetti
GET    /api/v1/projects/{id}     # Dettaglio progetto
POST   /api/v1/projects          # Crea progetto
PUT    /api/v1/projects/{id}     # Aggiorna progetto
DELETE /api/v1/projects/{id}     # Elimina progetto
```

#### Task
```http
GET    /api/v1/tasks             # Lista task
GET    /api/v1/tasks/{id}        # Dettaglio task
POST   /api/v1/tasks             # Crea task
PUT    /api/v1/tasks/{id}        # Aggiorna task
DELETE /api/v1/tasks/{id}        # Elimina task
PATCH  /api/v1/tasks/{id}/status # Cambia stato
```

#### Utenti
```http
GET    /api/v1/users             # Lista utenti
GET    /api/v1/users/{id}        # Dettaglio utente
PUT    /api/v1/users/{id}        # Aggiorna profilo
```

### Documentazione Completa

Per la documentazione interattiva completa (Swagger/OpenAPI):

```bash
# Genera la documentazione
php artisan l5-swagger:generate
```

Visita: **http://localhost:8000/api/documentation**

---

## 🧪 Testing

### Esegui i Test

```bash
# Tutti i test
php artisan test

# Con coverage
php artisan test --coverage

# Test specifici
php artisan test --filter=ProjectTest

# Test paralleli (più veloce)
php artisan test --parallel
```

### Test di Feature Disponibili

- ✅ Autenticazione e autorizzazione
- ✅ CRUD progetti
- ✅ CRUD task
- ✅ Gestione permessi
- ✅ API endpoints
- ✅ Notifiche email
- ✅ Upload file

### Esegui Analisi Codice

```bash
# PHPStan (analisi statica)
./vendor/bin/phpstan analyse

# PHP CS Fixer (code style)
./vendor/bin/php-cs-fixer fix

# Larastan
./vendor/bin/phpstan analyse --memory-limit=2G
```

---

## 🚢 Deployment

### Preparazione per Produzione

1. **Configura l'ambiente:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tuodominio.com
```

2. **Ottimizza l'applicazione:**
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Imposta i permessi:**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Deploy con Docker

```bash
# Build immagine
docker build -t taskmanager-pro .

# Avvia container
docker-compose up -d

# Esegui migrazioni
docker-compose exec app php artisan migrate --force
```

### Deploy su Server

Esempio configurazione Nginx:

```nginx
server {
    listen 80;
    server_name tuodominio.com;
    root /var/www/taskmanager-pro/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔧 Troubleshooting

### Problemi Comuni

#### 1. Errore "Please provide a valid cache path"
```bash
php artisan cache:clear
php artisan config:clear
```

#### 2. Errore permessi storage
```bash
chmod -R 775 storage bootstrap/cache
```

#### 3. Mix manifest not found
```bash
npm run build
```

#### 4. Database connection refused
- Verifica che MySQL sia in esecuzione
- Controlla le credenziali in `.env`
- Testa la connessione: `php artisan tinker` poi `DB::connection()->getPdo();`

#### 5. CORS errors nelle API
Configura `config/cors.php` e aggiungi i domini permessi

### Log e Debug

```bash
# Visualizza log in tempo reale
tail -f storage/logs/laravel.log

# Pulisci i log
php artisan log:clear

# Debug mode (solo sviluppo!)
APP_DEBUG=true
```

---

## 🤝 Contribuire

Le contribuzioni sono benvenute e apprezzate! 

### Come Contribuire

1. **Fork** il progetto
2. **Crea** un branch per la tua feature:
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Committa** le tue modifiche:
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push** sul branch:
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Apri** una Pull Request

### Guidelines

- Segui lo stile di codice PSR-12
- Scrivi test per le nuove funzionalità
- Aggiorna la documentazione
- Descrivi chiaramente le modifiche nella PR

### Code of Conduct

Questo progetto segue il [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md).

---

## 📄 Licenza

Questo progetto è distribuito sotto licenza **MIT**. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

---

## 👥 Autori

- **Mario Rossi** - *Sviluppatore principale* - [@mariorossi](https://github.com/mariorossi)

### Contributors

Grazie a tutti i contributori che hanno partecipato al progetto!

<a href="https://github.com/tuousername/taskmanager-pro/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=tuousername/taskmanager-pro" />
</a>

---

## 🙏 Ringraziamenti

- [Laravel Framework](https://laravel.com) - Il framework PHP più elegante
- [Tailwind CSS](https://tailwindcss.com) - Framework CSS utility-first
- [Livewire](https://laravel-livewire.com) - Componenti dinamici per Laravel
- [Alpine.js](https://alpinejs.dev) - Framework JavaScript minimalista
- [Chart.js](https://www.chartjs.org) - Grafici interattivi
- Tutti i contributors open source

---

## 📞 Contatti

- **Email:** support@taskmanager.com
- **Website:** [https://taskmanager-pro.com](https://taskmanager-pro.com)
- **Twitter:** [@TaskManagerPro](https://twitter.com/taskmanagerpro)
- **Discord:** [Join our server](https://discord.gg/taskmanager)

---

## 📊 Stats

![GitHub stars](https://img.shields.io/github/stars/tuousername/taskmanager-pro?style=social)
![GitHub forks](https://img.shields.io/github/forks/tuousername/taskmanager-pro?style=social)
![GitHub issues](https://img.shields.io/github/issues/tuousername/taskmanager-pro)
![GitHub pull requests](https://img.shields.io/github/issues-pr/tuousername/taskmanager-pro)

---

<p align="center">Made with ❤️ in Italy</p>
<p align="center">© 2024 TaskManager Pro. All rights reserved.</p>