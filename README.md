[![Tests](https://github.com/johnzgit/alshamel-inventory-demo/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/johnzgit/alshamel-inventory-demo/actions/workflows/tests.yml)

# Alshamel WMS - Inventory Adjustment Demo

<div align="center">

**[🔥 Live Demo: Try the Interactive UI Here](https://alshamel-inventory-demo-production.up.railway.app/)**

</div>

This is a modern, standalone Full-Stack Laravel 11 application designed for managing warehouse batch quantity adjustments using predefined reasons. It features a robust backend with concurrency control and a premium Glassmorphism frontend UI.

## 🚀 Key Features & Architectural Decisions

### 1. Concurrency Safety (Pessimistic Locking)
When adjusting inventory in a real warehouse, multiple operators might scan or update the same batch simultaneously.
To prevent **race conditions** and stock miscalculations, the core adjustment logic is wrapped in `DB::transaction()` using `lockForUpdate()` on the `Batch` model. This guarantees that stock increments/decrements are mathematically sound even under heavy concurrent load.

### 2. Premium Interactive UI (No Bloatware)
Instead of a simple API response, the frontend features a **Custom Glassmorphism SPA** built entirely with Vanilla JS and Native CSS. 
- **Data Grid:** Real-time search and filtering across products and batches.
- **Immersive Modal:** Context-aware adjustment workflow that calculates variance instantly.
- **Zero Build Step:** Vite and Node.js dependencies were intentionally bypassed for the frontend to ensure maximum deployment speed and extreme lightweight performance.

### 3. Strict Validation & API Resources
- Advanced `Rule::exists()` validation ensures that adjustments can only be made using **active (`is_active = true`)** reasons of the exact type (`type = 'inventory_adjustment'`).
- `JsonResource` transformers are used to shield database structures from the frontend, eager-loading deeply nested relations (Warehouse -> Batch -> Product) without N+1 query issues.

### 4. Automated CI/CD (Railway + Nixpacks)
The repository is fully configured for modern CI/CD:
- `railway.json` automatically triggers `php artisan migrate --force && php artisan db:seed --force` upon deployment.
- Seamlessly spins up a production-ready SQLite database populated with demo data on every fresh deployment.

---

## 🛠 Local Setup Instructions (Docker)

This project uses Laravel Sail. No local PHP or MySQL installation is required.

1. **Clone the repository**:
   ```bash
   git clone https://github.com/johnzgit/alshamel-inventory-demo.git
   cd alshamel-inventory-demo
   ```

2. **Copy the environment file**:
   ```bash
   cp .env.example .env
   ```

3. **Install Dependencies & Start the application**:
   ```bash
   # Install PHP dependencies via Docker
   docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs
   
   # Start the containers
   ./vendor/bin/sail up -d
   ```

4. **Initialize Application**:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate --seed
   ```

## Automated Test Suite

This project includes a comprehensive, automated test suite built with **PHPUnit** and integrated into **GitHub Actions** for continuous integration.

### Test Coverage Highlights
- **100% Core API Coverage**: 5 in-depth test cases covering all 4 REST endpoints.
- **Database State Assertions**: Tests don't just check API responses, but actively verify pessimistic locking and database row transformations (e.g. asserting that a `-8` inventory adjustment correctly updates the `batches` table).
- **Validation & Security**: Includes edge cases like rejecting adjustments with inactive reason codes (`422 Unprocessable Entity`).

To run the tests locally in isolated memory:
```bash
./vendor/bin/sail artisan test
```

---

## 📡 API Endpoints Reference

If you prefer to test via Postman or Curl instead of the Web UI, the API is accessible at `/api`.

### 1. List Adjustment Reasons
- **Endpoint:** `GET /api/reasons`
- **Description:** Returns all active predefined reasons that can be used for inventory adjustments.

### 2. Create an Inventory Adjustment
- **Endpoint:** `POST /api/inventory-adjustments`
- **Payload:**
  ```json
  {
    "batch_id": 1,
    "reason_id": 1,
    "new_quantity": 92,
    "note": "Physical count mismatch found by warehouse team"
  }
  ```

### 3. Fetch Batches
- **Endpoint:** `GET /api/batches`
- **Description:** Retrieves all available batches with eager-loaded product and warehouse names.
