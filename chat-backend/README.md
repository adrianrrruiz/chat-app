# Chat Backend con Symfony + Ratchet + SQLite

Tecnologías utilizadas:

- **Symfony 6.4**
- **Ratchet (WebSockets)**
- **SQLite (Doctrine ORM)**

## Instalación

Clonar el repositorio:

```bash
git clone https://github.com/TU-USUARIO/chat-backend.git
cd chat-backend
```

Instalar dependencias PHP:

```bash
composer install
```

Configurar base de datos en .env:

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

Ejecutar migraciones:

```bash
php bin/console doctrine:migrations:migrate
```

## Levantar servidor WebSocket

```bash
php bin/chat-server.php
```

Servidor quedará escuchando en:

```
ws://localhost:8080
```

## Probar conexión
En la consola del navegador:

```js
const ws = new WebSocket("ws://localhost:8080");
ws.onopen = () => ws.send("Hola desde cliente!");
ws.onmessage = (event) => console.log("Nuevo mensaje:", event.data);
```
