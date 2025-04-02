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

3. Asegúrate de que el archivo `.env` del backend tenga la configuración correcta de la base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=vote
DB_USERNAME=vote
DB_PASSWORD=vote
```

4. Inicia los contenedores Docker:
```bash
docker-compose up -d
```

5. Instala las dependencias del backend:
```bash
docker-compose exec backend composer install
```

6. Genera la clave de la aplicación:
```bash
docker-compose exec backend php artisan key:generate
```

7. Ejecuta las migraciones y seeders:
```bash
docker-compose exec backend php artisan migrate:fresh --seed
```

## Poblar la Base de Datos

Hay dos formas de poblar la base de datos con datos iniciales:

1. Durante la instalación (como se menciona en el paso 7):
```bash
docker-compose exec backend php artisan migrate:fresh --seed
```

2. Si ya tienes la base de datos con migraciones y solo quieres agregar los datos de prueba:
```bash
docker-compose exec backend php artisan db:seed
```

Los seeders crearán:
- Un usuario administrador (admin@admin.com / password)
- 47 votantes regulares
- 3 candidatos

**Nota**: `migrate:fresh` borrará todos los datos existentes. Usa `db:seed` si solo quieres agregar datos sin borrar los existentes.

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

- Ver logs de un servicio específico:
```bash
docker-compose logs -f [backend|frontend|db]
```

## Problemas Comunes y Soluciones

### Error de Conexión a la Base de Datos
Si encuentras un error de conexión a la base de datos (SQLSTATE[HY000] [2002] Connection refused), verifica que:
1. El archivo `.env` del backend tenga la configuración correcta de la base de datos
2. Los contenedores estén corriendo (`docker-compose ps`)
3. La base de datos esté accesible (`docker-compose exec db mysql -u vote -pvote -e "SHOW DATABASES;"`)

### Frontend no Accesible
Si no puedes acceder al frontend en http://localhost:3000:
1. Verifica que el contenedor del frontend esté corriendo
2. Revisa los logs del frontend: `docker-compose logs frontend`
3. Asegúrate de que no haya conflictos de puertos en tu máquina local

### Reinicio Completo
Si encuentras problemas persistentes, puedes intentar un reinicio completo:
```bash
# Detener y eliminar todos los contenedores y volúmenes
docker-compose down -v

# Reconstruir y reiniciar los contenedores
docker-compose up -d --build

# Ejecutar las migraciones y seeders
docker-compose exec backend php artisan migrate:fresh --seed
```

## Documentación Adicional

- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Docker](https://docs.docker.com/)
- [Documentación de React](https://reactjs.org/docs)
- [Documentación de Vite](https://vitejs.dev/guide/)
