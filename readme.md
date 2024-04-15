![Logo de truck i]()

# Trashumancia

## Instalación y Configuración

### Clonar el Repositorio 📋

Para clonar el repositorio, asegúrate de tener una clave SSH pública en tu cuenta de GitLab. Si no la tienes, puedes seguir [estas instrucciones](https://www.theserverside.com/blog/Coffee-Talk-Java-News-Stories-and-Opinions/How-to-configure-GitLab-SSH-keys-for-secure-Git-connections) para crearla.

```
git clone git@gitlab.com:dani.rg15/truck-i.git
```

### Instalar los Paquetes 📦

Ejecuta los siguientes comandos en la terminal:

```bash
composer install
npm install
```

### Configurar el Archivo .env 🔒

> **Consejo:** Es importante mantener tu archivo `.env` seguro y no subirlo a ningún repositorio público.

```bash
cp .env.example .env
```

Luego, configura tus credenciales locales:

```plaintext
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Preparar la Base de Datos 🗄️

> **Importante:** Antes de importar, asegúrate de tener la base de datos creada.

**Crear Base de Datos:**

```sql
mysql -u root -p
CREATE DATABASE truck-i DEFAULT CHARACTER SET = 'utf8mb4';
```

**Importar Base de Datos:**

Descarga la copia desde [este enlace](). En caso de no poder

```bash
mysql -u root -p truck-i < truck_i_pre.sql
```

En caso de no poder descargar la copia ejecuta las migraciones

```bash
php artisan migrate
```

## Uso 🚀

**Generar la Clave de la Aplicación:**

Solo es necesario ejecutarlo la primera vez de uso del proyecto.

```bash
php artisan key:generate
```

**Iniciar el Servidor de Laravel y NPM:**

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```
