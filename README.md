# Sistema de Votación

Sistema de votación desarrollado con Laravel 10 y React, utilizando Docker para el entorno de desarrollo.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

## Instalación

1. Clona el repositorio:
```bash
git clone https://github.com/Ju1it0/vote.git
cd vote
```

2. Copia el archivo de variables de entorno del backend:
```bash
cp backend/.env.example backend/.env
```

3. Inicia los contenedores Docker:
```bash
docker-compose up -d
```

4. Instala las dependencias del backend:
```bash
docker-compose exec backend composer install
```

5. Genera la clave de la aplicación:
```bash
docker-compose exec backend php artisan key:generate
```

6. Ejecuta las migraciones y seeders:
```bash
docker-compose exec backend php artisan migrate:fresh --seed
```

## Acceso a la Aplicación

La aplicación estará disponible en:
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000
- Base de datos MySQL: localhost:3306

## Credenciales por Defecto

- **Administrador**:
  - Email: admin@admin.com
  - Contraseña: password

## Estructura del Proyecto

El proyecto utiliza las siguientes tecnologías:

- **Backend**: Laravel 10 (/backend)
- **Frontend**: React + Vite (/frontend)
- **Base de datos**: MySQL 8.0
- **Servidor web**: Nginx
- **PHP**: 8.2
- **Node.js**: 18

## Comandos Útiles

- Iniciar los contenedores:
```bash
docker-compose up -d
```

- Detener los contenedores:
```bash
docker-compose down
```

- Ver logs:
```bash
docker-compose logs -f
```

## Documentación Adicional

- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Docker](https://docs.docker.com/)
- [Documentación de React](https://reactjs.org/docs)
- [Documentación de Vite](https://vitejs.dev/guide/)
