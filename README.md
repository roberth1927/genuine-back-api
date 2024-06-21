# Proyecto de API con Laravel y Dialogflow
Este proyecto implementa una API RESTful usando Laravel para gestionar datos de productos y categorías, y una integración con un bot de Dialogflow para consultar la cantidad de productos disponibles en una categoría específica.

## Despliegue
La API está desplegada en Railway en la siguiente URL:
 [https://genuine-back-api-production.up.railway.app/]

## Rutas de la API
- `GET /api/categories` - Obtiene todas las categorías.
- `GET /api/categories/{id}` - Obtiene una categoría por ID.
- `GET /api/categories/{id}/products` - Obtiene los productos en una categoría específica.
- `GET /api/categories/{id}/product-count` - Obtiene la cantidad de productos en una categoría específica.
- `POST /api/webhook` - Webhook para Dialogflow.

### Instalación y Despliegue Local
1. Clona el repositorio desde: [https://github.com/roberth1927/genuine-back-api.git]

2. Instala las dependencias:
     ```bash
     composer install && npm install 
   ```
3. Configura las variables de entorno en `.env`.
    ```bash
    npm install
  ```
4. Ejecuta las migraciones y seeders
  ```bash
    php artisan migrate --force && php artisan db:seed
  ```
5. Inicia el servidor local:
    ```bash
        php artisan serve
    ```

## Versiones
Laravel: 11.9.x
PHP: 8.2

## Contacto
Si tienes alguna pregunta, no dudes en contactarnos a través del correo electrónico: [robinmoralesquiroz@gmail.com]. Si deseas obtener más información sobre cómo ejecutar  la aplicacion, también estamos disponibles para ayudarte.
