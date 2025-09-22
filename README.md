#  DeepWeB

**DeepWeB** es un foro de discusión orientado al mundo gamer en fase de desarrollo.  
Un espacio diseñado para jugadores adultos que buscan compartir soluciones, guías, resolver dudas técnicas, optimizar sus juegos y debatir sobre tendencias de la industria.

---

##  Características principales

- **Autenticación segura**  
  - Registro de usuarios con contraseñas encriptadas (hashing con `password_hash`).  
  - Inicio y cierre de sesión con control mediante variables de sesión.  

- **Gestión de hilos y respuestas**  
  - Creación de temas clasificados por categorías (Noticias, Tendencias, Optimización, etc.).  
  - Posibilidad de responder a los hilos de otros usuarios.  
  - Eliminación de tus propios hilos o respuestas.  

- **Favoritos**  
  - Guardar hilos importantes en la sección *Favoritos*.  
  - Opción de quitar un hilo de favoritos.  

- **Categorías con filtrado dinámico**  
  - Vista de todas las categorías con sus hilos recientes.  
  - Sistema de filtrado para mostrar únicamente los hilos de una categoría seleccionada.  

- **Modo Gamer (Dark Mode)**  
  - Interruptor estilo *on/off* para activar un **modo oscuro gamer** con colores neón (verde y cyan).  
  - Preferencia guardada en `localStorage` para recordar el modo entre visitas.  

- **Cookies**  
  - Aviso de aceptación de cookies al ingresar por primera vez.  
  - Se almacena la preferencia del usuario para no volver a mostrar el aviso.  

- **Interfaz moderna y responsive**  
  - Desarrollado con **Bootstrap 5** para compatibilidad en móviles, tablets y escritorio.  
  - Diseño limpio y oscuro por defecto, con opción de personalización gamer.  

---

## 📂 Estructura del proyecto

```
/deepwebb
├── index.php             # Página principal: hilos recientes
├── view_topic.php        # Vista de un hilo específico y sus respuestas
├── create_topic.php      # Crear un nuevo hilo
├── login.php             # Inicio de sesión
├── register.php          # Registro de nuevos usuarios
├── logout.php            # Cerrar sesión
├── favoritos.php         # Ver hilos guardados en favoritos
├── categorias.php        # Listar categorías con filtrado
├── includes/
│   ├── conedb.php        # Conexión a la base de datos
│   └── funciones.php     # Funciones comunes (CRUD, validaciones, helpers)
├── css/
│   └── estilos.css       # Estilos personalizados + modo gamer
├── js/
│   └── script.js         # Funcionalidad cliente (modo gamer, confirmaciones, scroll)
├── img/
│   ├── logo.png          # Logo del foro (ejemplo)
│   └── anunciodeepweb.png # Imagen de anuncio lateral en index
├── README.md             # Este archivo
└── deepwebb_completa.sql # Script con la estructura y datos de prueba de la BD
```

---

## 🗄️ Base de datos

La base de datos se llama **`deepwebb`** e incluye las siguientes tablas:

- `usuarios` → gestión de cuentas de usuario.  
- `categorias` → categorías de discusión.  
- `hilos` → los temas creados por los usuarios.  
- `respuestas` → respuestas dentro de cada hilo.  
- `favoritos` → relación entre usuarios e hilos guardados.  

Se incluye un script `deepwebb_completa.sql` con la estructura.  

---

## 📸 Vistas principales

- **Index.php**  
  Lista de hilos recientes con título, fecha, usuario y categoría.  

- **View_topic.php**  
  Vista de un tema específico, sus respuestas, opción de responder y botones para:  
  - Guardar en favoritos  
  - Eliminar tus respuestas  
  - Eliminar tu hilo (si eres el creador)  

- **Categorias.php**  
  Vista de todas las categorías, cada una con hasta 3 hilos recientes.  
  Incluye un **filtro desplegable** para mostrar solo una categoría.  

- **Favoritos.php**  
  Lista de hilos guardados con opción de volver al hilo o al inicio.  

- **Modo Gamer**  
  Toggle (interruptor) que activa el modo oscuro gamer en todas las páginas.  

---

## ⚙️ Instalación

1. Copiar la carpeta del proyecto en el directorio de WAMP/XAMPP:  
   ```
   C:\wamp64\www\deepwebb
   ```

2. Crear la base de datos en phpMyAdmin:  
   ```sql
   CREATE DATABASE deepwebb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Importar el script `deepwebb_completa.sql`.  

4. Abrir en el navegador:  
   ```
   http://localhost/DeepWebFinal
   ```

---

## Autores

- Proyecto desarrollado como práctica de **PHP + MySQL + Bootstrap + JavaScript**.  
 
