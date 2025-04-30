# FritoLay – Plataforma de Pedidos y Soporte

> **Proyecto a medida** para D&J Distribuciones (FritoLay Colombia), desarrollado por **Publienred C.A.**, especialistas en software a medida.

---

## 📋 Objetivo

FritoLay es un sistema integral para comercios grandes y pequeños que optimiza el flujo de pedidos y ofrece un canal de soporte con tickets, facilitando:

- Gestión rápida de pedidos.
- Comunicación directa con el equipo de soporte.
- Notificaciones vía email y en la aplicación.
- Panel administrativo para el equipo interno.

---

## 🚀 Instalación

### Requisitos

1. **PHP** ≥ 8.1  
2. **Composer**  
3. **Node.js** ≥ 16 + **npm** o **yarn**  
4. **MySQL** o MariaDB  
5. **Git**

### Pasos

1. **Clonar el repositorio**  
   ```bash
   git clone https://github.com/roottgus/fritolaynew.git fritolay-proyecto
   cd fritolay-proyecto
Instalar dependencias de PHP

bash
Copiar
Editar
composer install
Variables de entorno

bash
Copiar
Editar
cp .env.example .env
Edita .env y ajusta al menos:

dotenv
Copiar
Editar
APP_NAME="FritoLay – D&J Distribuciones"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fritolay_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

# (Opcional) Correo:
MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-servidor.com
MAIL_PORT=587
MAIL_USERNAME=usuario@tu-dominio.com
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@fritolay.com
MAIL_FROM_NAME="${APP_NAME}"
Generar clave de aplicación

bash
Copiar
Editar
php artisan key:generate
Migraciones y datos iniciales

bash
Copiar
Editar
php artisan migrate --seed
Frontend (CSS/JS)
Con npm:

bash
Copiar
Editar
npm install
npm run dev
O con Yarn:

bash
Copiar
Editar
yarn
yarn dev
Levantar servidor

bash
Copiar
Editar
php artisan serve
Accede en http://127.0.0.1:8000.

⚙️ Uso
Cliente:

Regístrate o inicia sesión en /login.

Gestión de pedidos (/pedidos), tu cuenta (/mi-cuenta) y soporte (/tickets).

Administrador:

Accede en /admin/dashboard.

Controla productos, usuarios, órdenes, anuncios, ofertas y tickets.

Si un no-adm intenta acceder a /admin/*, verá “Acceso Restringido”.

📬 Notificaciones
Email:

Nuevo ticket → Administrador recibe notificación.

Respuesta del ADM → Cliente recibe email.

Ticket cerrado → Cliente recibe aviso.

En-app con Livewire y Toastr.

👷‍♂️ Sobre el equipo
Este proyecto fue diseñado y desarrollado por Publienred C.A., tu aliado en soluciones de software a medida.

📄 Licencia
MIT © 2025 Publienred C.A.