# Lumbung Data - Agent Customization Guide

**Lumbung Data** is a comprehensive **Village Information System (SID - Sistem Informasi Desa)** built with Laravel 12, designed to help villages digitally manage population data, services, finances, and community programs.

## Quick Start

### Prerequisites
- PHP 8.2+, MySQL 8.0+, Node.js 20
- Docker & Docker Compose (optional, for containerized development)

### Development Setup
```bash
# Install dependencies
composer install
npm install

# Generate app key & setup environment
cp .env.example .env
php artisan key:generate

# Database: Run migrations + seeders
php artisan migrate --seed

# Start development servers
npm run dev                # Frontend (Vite on port 5173)
php artisan serve         # Laravel backend (port 8000)

# OR use Docker (one command)
docker-compose up -d      # All services + MySQL on port 3307
```

### Key Ports
- **8000**: Laravel app (docker)
- **5173**: Vite dev server
- **8080**: PHPMyAdmin (docker)
- **3307**: MySQL (docker)

---

## Architecture & Project Structure

### Application Layers
```
app/
├── Models/          → Data entities (Penduduk, Keluarga, Surat, etc.)
├── Controllers/     → Request handling organized by feature
├── Policies/        → Authorization logic
├── Services/        → Business logic (reusable, testable)
├── Http/Requests/   → Form validation rules
├── Http/Middleware/ → Request pipeline
├── Traits/          → Shared behavior
├── Exports/         → Excel export handlers (Maatwebsite)
└── Console/Commands/→ Artisan CLI commands
```

### Key Feature Modules (By Directory)

| Module | Purpose | Key Controllers |
|--------|---------|-----------------|
| **Kependudukan** | Population & family management | PendudukController, KeluargaController, RumahTanggaController |
| **Layanan Surat** | Digital letter requests & archive | LayananSuratController |
| **Keuangan** | Financial tracking, APBDes budgeting | KeuanganController |
| **Analisis** | Surveys & respondent analysis | AnalisisMasterController |
| **Kesehatan** | Health monitoring | KesehatanController |
| **Kehadiran** | Attendance & working hours | InputKehadiranController, RekapitulasiController |
| **InfoDesa** | Village identity, announcements, partnerships | IdentitasDesaController, WilayahController |

### Database Design Patterns
- **Soft deletes**: Use `$table->softDeletes()` for data preservation
- **Pivot tables**: `keluarga_anggota`, `rumah_tangga_penduduk` for M:M relations
- **Timestamps**: All models have `created_at`, `updated_at`
- **Status fields**: Use enums (e.g., `status_hidup: 'hidup'|'mati'|'pindah'|'hilang'`)
- **References**: Models in `app/Models/Ref/` are lookup tables (RefAgama, RefPekerjaan, etc.)

---

## Naming Conventions

### Controllers
- Location: `app/Http/Controllers/{Feature}/{SubFeature}Controller.php`
- Naming: PascalCase with "Controller" suffix
- Example: `app/Http/Controllers/Admin/Kependudukan/PendudukController.php`

### Views (Blade Templates)
- Location: `resources/views/{feature}/{subfeature}/`
- Indonesian naming: Use Indonesian feature names (not English)
- Examples:
  - `resources/views/admin/kependudukan/penduduk/index.blade.php`
  - `resources/views/admin/layanan-surat/permohonan/index.blade.php`

### Routes
- Feature-specific route files in `routes/` (e.g., `kesehatan.php`, `superadmin.php`)
- Route prefixes match features: `Route::prefix('kependudukan')->group(...)`
- Named routes: `route('admin.penduduk.index')`

### Models
- Namespace: `App\Models` or `App\Models\Ref` (for reference/lookup tables)
- Indonesian names are acceptable
- Use PascalCase: `Penduduk`, `SuratPermohonan`, `LayananMandiri`

---

## Development Workflow

### Common Commands

```bash
# Database
php artisan migrate                # Run pending migrations
php artisan migrate:fresh --seed   # Reset + seed (dev only)
php artisan tinker                 # Interactive shell for testing

# Code generation (Artisan)
php artisan make:model Penduduk -m -c --resource    # Model + migration + controller
php artisan make:request CreatePendudukRequest       # Form request
php artisan make:migration create_penduduk_table     # Raw migration
php artisan make:policy PendudukPolicy --model=Penduduk

# Testing
php artisan test                   # Run all tests (PHPUnit)
php artisan test --filter=Penduduk # Run specific test

# Code quality
./vendor/bin/pint                  # Auto-format code (Laravel Pint)

# Assets
npm run build                      # Production build (Vite)
npm run dev                        # Development watch mode (Vite)
```

### Excel Import/Export
- Uses **Maatwebsite Excel** (`maatwebsite/excel`)
- Export classes in `app/Exports/` (e.g., `PendudukExport.php`)
- Pattern: Extend `FromCollection` or `FromQuery`
- Example: `Excel::download(new PendudukExport($query), 'penduduk.xlsx')`

### PDF Generation
- Uses **DomPDF** (`barryvdh/laravel-dompdf`)
- Example: `Pdf::loadView('path.to.view', $data)->download('file.pdf')`

---

## Key Libraries & Dependencies

### Backend
| Package | Purpose | Usage |
|---------|---------|-------|
| **laravel/framework** (v12) | Web framework | Core application |
| **livewire/livewire** (v4) | Dynamic components | Real-time UI without JS |
| **laravel/socialite** | Social auth | Multi-auth integration |
| **barryvdh/laravel-dompdf** | PDF generation | Letter export |
| **maatwebsite/excel** | Excel handling | Import/export data |
| **phpoffice/phpword** | Word docs | Document generation |
| **laravel/tinker** | REPL shell | Interactive testing |

### Frontend
| Package | Purpose |
|---------|---------|
| **tailwindcss** (v4) | Utility CSS | Styled with `@apply` directives |
| **vite** | Module bundler | Asset compilation |
| **alpine.js** (if used) | Lightweight JS | Modal/dropdown interactions |

---

## Important Project Specifics

### Access Control & Policies
- Located in: `app/Policies/`
- Use Laravel's authorization gates for checking permissions
- Attach via `authorize()` in controllers or middleware
- Admin routes typically protected by role checks or policies

### Configuration Files
- `.env` file holds database credentials, mail settings, API keys
- Key config files: `config/app.php`, `config/database.php`, `config/auth.php`
- Don't commit `.env`; use `.env.example` as template

### Soft Deletes Behavior
- Queries by default **exclude soft-deleted records**
- Use `->withTrashed()` to include deleted, `->onlyTrashed()` for only deleted
- Always consider this when filtering or counting data

### File Storage
- Public uploads: `storage/app/public/` (accessible via web)
- Use `Storage::disk('public')->put()` for file handling
- Run `php artisan storage:link` to create public symlink (for Docker, may be already done)

---

## Code Style & Best Practices

### Model Scopes (Query Filters)
- Define reusable query filters in models using `scope` methods
- Example: 
  ```php
  public function scopeWargaAktif($query) {
      return $query->where('status_hidup', 'hidup');
  }
  // Usage: Penduduk::wargaAktif()->paginate()
  ```

### Error Handling
- Wrap database queries in try-catch blocks in controllers (as seen in DashboardController)
- Return user-friendly error messages in views
- Use `notify()` or flash messages for user feedback

### Pagination & Filtering
- Always use `paginate()` with `appends($request->query())` to preserve filters across pages
- Default per_page is typically 10–25; respect user selection via `$request->get('per_page', 10)`

### Collections & Relationships
- Use Eloquent relationships (`hasMany`, `belongsTo`, `belongsToMany`) heavily
- Eager load related data with `->with(['relation1', 'relation2'])`
- Use `->load()` for lazy loading in controllers

---

## Testing

- **Unit Tests**: Logic-focused, database-less tests in `tests/Unit/`
- **Feature Tests**: Full integration tests in `tests/Feature/`
- **Test Database**: Uses in-memory SQLite by default; configure in `phpunit.xml`

Run tests:
```bash
php artisan test
php artisan test tests/Feature/PendudukControllerTest.php
```

---

## Deployment Notes

### Docker Build
- `Dockerfile` and `Dockerfile.railway` for production builds
- Runs migrations automatically on container start (check entrypoint in Dockerfile)
- Environment: Set `.env` values via Docker env vars or config files

### Key Env Variables
```
DB_CONNECTION=mysql
DB_HOST=db              # Service name in docker-compose
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

APP_KEY=                # Generate with `php artisan key:generate`
APP_DEBUG=false         # Set to false in production
```

---

## Common Debugging Tips

1. **Database issues**: Use `php artisan tinker` to test queries interactively
2. **Migrations stuck**: Check `migrations` table; manually rollback if needed
3. **Relationships not loading**: Check foreign key constraints and model definitions
4. **Views not rendering**: Verify view file paths match controller compact() variables
5. **Excel export fails**: Check model relationships are properly eager-loaded
6. **Soft deletes showing deleted records**: Explicitly use `->withTrashed()` or check scope

---

## Useful Links

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Livewire Documentation](https://livewire.laravel.com)
- [Maatwebsite Excel](https://docs.laravel-excel.com)
- [DomPDF](https://github.com/barryvdh/laravel-dompdf)
- [Tailwind CSS](https://tailwindcss.com)

---

## Next Steps for Improvements

When working on new features:
1. **Add a scope method** to models for commonly used filters (e.g., `scopeAktif()`, `scopeByWilayah()`)
2. **Create a Service class** for complex business logic (separate from controller)
3. **Add tests** for critical paths (permissions, data transformations)
4. **Use form requests** (`make:request`) for validation instead of inline validation
5. **Document API routes** if adding endpoints for frontend consumption
