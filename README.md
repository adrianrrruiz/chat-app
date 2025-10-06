# 🧩 Proyecto: Chat Web con Symfony + Svelte

## 📘 Descripción general

Este proyecto implementa un **chat en tiempo real** utilizando:
- **Backend:** Symfony + Ratchet (WebSocket) + Doctrine + SQLite  
- **Frontend:** Svelte (arquitectura MVC)  
- **Contenedores:** Docker Compose para despliegue completo  

Cuenta además con un **CRUD de entidades (Persona, Chat, Mensaje)** y un sistema de **login por número de teléfono**.  

---

## ⚙️ Requisitos previos

Antes de ejecutar el proyecto asegúrate de tener instalado:

| Requisito | Versión recomendada |
|------------|--------------------|
| Docker | ≥ 24.x |
| Docker Compose | ≥ 2.x |
| Git | ≥ 2.x |
| Node.js | ≥ 20.x |
| Composer | ≥ 2.x *(solo si deseas ejecutar fuera de Docker)* |

---

## 🚀 Pasos para desplegar el proyecto

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/tuusuario/chat-app.git
cd chat-app
```

---

### 2️⃣ Estructura principal
```
chat-app/
│
├── chat-backend/         # Código PHP (Symfony)
│   ├── src/
│   ├── bin/chat-server.php   # Servidor HTTP + WebSocket
│   └── docker/php/Dockerfile
│
├── chat-frontend/        # Código del cliente (Svelte)
│   ├── src/views/
│   └── docker/svelte/Dockerfile
│
└── docker-compose.yml    # Orquestación de contenedores
```

---

### 3️⃣ Construir y levantar los contenedores
Desde la raíz del proyecto:

```bash
docker compose up --build
```

Esto crea y ejecuta dos servicios:
- 🧠 **backend** → corre en `http://localhost:8080`
- 💬 **frontend** → corre en `http://localhost:5173`

> 💡 La primera vez puede tardar varios minutos, ya que instala dependencias de PHP y Node.js.

---

### 4️⃣ Verificar los servicios

- Accede al **frontend (Svelte)** en  
  👉 http://localhost:5173  
  Aquí podrás:
  - Iniciar sesión ingresando un número de teléfono
  - Chatear en tiempo real
  - Ver la lista de personas creadas

- El **backend (Symfony + Ratchet)** queda activo en  
  👉 http://localhost:8080  
  Este servidor gestiona tanto las peticiones HTTP `/api/*` como los sockets WebSocket.

---

### 5️⃣ Ejecutar comandos dentro de los contenedores (opcional)
Para entrar al contenedor del backend:

```bash
docker compose exec backend bash
```

Luego, puedes ejecutar comandos de Symfony, por ejemplo:

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:query:sql "SELECT * FROM persona;"
```

---

### 6️⃣ Apagar los contenedores
```bash
docker compose down
```

---

## 🧠 Arquitectura general

```text
Cliente (Svelte)  --->  Backend Symfony (API REST)
       ↕                       ↕
   WebSocket <----------> ChatServer (Ratchet)
```

- **Svelte:** maneja el flujo MVC (modelos, controladores y vistas).
- **Symfony:** expone endpoints `/api/...` para CRUD.
- **Ratchet:** permite la comunicación en tiempo real.
- **Doctrine + SQLite:** manejan la persistencia de datos.

---

## 🧪 Endpoints principales del backend

| Método | Endpoint | Descripción |
|---------|-----------|-------------|
| `POST` | `/api/persona` | Crea o devuelve una persona según el teléfono |
| `GET` | `/api/personas` | Lista todas las personas |
| `POST` | `/api/mensaje` | Crea un mensaje asociado a una persona y chat |
| `GET` | `/api/mensajes` | Lista mensajes de un chat |

---

## 🧰 Variables de entorno (.env)

El archivo `.env` del backend debe contener:

```
APP_ENV=dev
DATABASE_URL=sqlite:////app/var/data.db
```

---

## 🧾 Notas adicionales

- Si hay errores de permisos con SQLite:
  ```bash
  docker compose exec backend chmod 777 -R var/
  ```
- Para reiniciar la base de datos, borra el archivo `var/data.db` y vuelve a ejecutar las migraciones.

---