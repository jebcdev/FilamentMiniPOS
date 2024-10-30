
# MiniPOS - Sistema de Punto de Venta

Este es un sistema MiniPOS desarrollado en **Laravel 11** y **Filament PHP 3** con una base de datos **MySQL**. Diseñado para gestionar de forma eficaz categorías de productos, inventario, clientes, y ventas en un entorno de punto de venta.  

## Características Principales

### Módulos:

- **Categorías:** Gestión de categorías de productos para una organización ordenada y ágil.
- **Productos:** Administración de productos, permitiendo agregar, editar, y eliminar productos con detalles completos de cada uno.
- **Clientes:** Registro y gestión de clientes, mejorando el seguimiento de ventas y personalización de servicios.
- **Compras y Detalles de Compras:** Registro detallado de compras realizadas, con desglose de productos y precios por unidad y cantidad.
- **Ventas y Detalles de Ventas:** Seguimiento detallado de las ventas, incluidas las especificaciones de productos, precios y cantidades.

### Requisitos Previos

1. **Base de Datos MySQL:** Configurar la base de datos y las credenciales en el archivo `.env`.
2. **Link de almacenamiento:** Ejecute `php artisan storage:link` para crear el enlace simbólico al almacenamiento de archivos públicos.
3. **Configuración de Archivos Públicos:** Asegurarse de que `FILESYSTEM_DISK` esté configurado como `public` en el archivo `.env`.

### Instalación

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/jebcdev/FilamentMiniPOS.git
   cd MiniPOS
   ```

2. **Instala las dependencias**
   ```bash
   composer install
   ```
   ```bash
   npm install
   ```

3. **Configura el archivo `.env`**
   ```bash
   php artisan key:generate
   ```
   Muy Importante Configurar el:
   ```bash
   APP_URL=http://minipos.test
   ```
   Cambialo por tu URL

4. **Migraciones y Seeders**
   Ejecuta las migraciones para crear la estructura de la base de datos:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage Link**
   Ejecuta el siguiente comando para crear el 
   enlace simbolico para que funcione la 
   visualizacion de las imágenes:
   ```bash
   php artisan storage:link --force
   ```

6. **Inicia el servidor de desarrollo**
   ```bash
   php artisan serve
   ```
   O accede a tu URL

### Créditos

Desarrollado por { JEBC-Dev } en **Laravel 11** y **Filament PHP 3**.