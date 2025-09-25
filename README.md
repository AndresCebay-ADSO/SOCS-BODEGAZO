# SOCS - Sistema Online de Comercialización de Software

![Badge en desarrollo](https://img.shields.io/badge/ESTADO-%20EN%20DESARROLLO-green)
![Licencia](https://img.shields.io/badge/LICENCIA-MIT-blue)

Plataforma de e-commerce especializada en calzado para optimizar procesos comerciales y mejorar la experiencia del usuario.

## 📌 Tabla de Contenidos
- [Hacer al clonar](#hacer-al-clonar)

- [Propósito del Documento](#-propósito-del-documento)
- [Alcance del Software](#-alcance-del-software)
- [Equipo de Desarrollo](#-equipo-de-desarrollo)
- [Tecnologías Utilizadas](#-tecnologías-utilizadas)
- [Funcionalidades Clave](#-funcionalidades-clave)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Licencia](#-licencia)

## 🎯 Propósito del Documento
Guía detallada para comprender el alcance y operatividad del sistema SOCS, facilitando el entendimiento tanto para desarrolladores como usuarios finales.

## 🌐 Alcance del Software
- Plataforma enfocada en comercialización de calzado
- Beneficio para personas de la región
- Alineación con modelo de mercado virtual
- Acceso multiplataforma a productos/servicios

## 👥 Equipo de Desarrollo
| Nombre | Rol |
|--------|-----|
| Andres Stiven Cebay Ceballos | Analista, Diseñador, Programador |
| Linda Katherine Andino Lopez | Analista, Diseñadora, Programadora |
| Cristian Camilo Yasno Quilindo | Analista, Diseñador, Programador |
| Felipe Arturo Quivano Chila | Analista, Diseñador, Programador |
| Oscar Ivan Muchicon Liz | Analista, Diseñador, Programador |

## 💻 Tecnologías Utilizadas
**Frontend:**
- Blade (vistas)
- Tailwind CSS
- JavaScript (mínimo)

**Backend:**
- Laravel (PHP)
- MySQL

**Infraestructura:**
- Content Delivery Network (CDN)

## 🚀 Funcionalidades Clave
### Gestión Integral
- 📦 Inventario (CRUD completo)
- 👥 Clientes (registro, roles, historial)
- 🔔 Notificaciones automáticas
- 🛒 Proceso de pedidos completo
- 📊 Análisis de ventas y reportes

### Experiencia de Usuario
- 💳 Múltiples métodos de pago
- ❤️ Lista de favoritos
- 🔍 Búsqueda avanzada
- 🎨 Personalización de productos

### Seguridad
- 🔒 Encriptación de datos
- 🛡️ Protección de información financiera
- 📜 Gestión de permisos por roles

## 📋 Requisitos
### Funcionales (RF)
1. RF01: Gestión de inventario
2. RF02: Gestión de usuarios/roles
3. RF03: Sistema de notificaciones
4. RF04: Ciclo completo de pedidos
5. RF05: Análisis de ventas
6. RF06: Métodos de pago integrados
7. RF07: Gestión de favoritos
8. RF08: Carrito de compras avanzado

### No Funcionales (RNF)
1. RNF01: Alto rendimiento
2. RNF02: Usabilidad multiplataforma
3. RNF03: Seguridad robusta
4. RNF04: Disponibilidad 24/7
5. RNF05: Mantenibilidad
6. RNF06: Diseño atractivo

## ✅ CASOS DE USO – SOCS-PROJECT

---

### 👥 ACTORES

| Actor         | Descripción                                                   |
|---------------|---------------------------------------------------------------|
| **Cliente**       | Usuario que navega el sitio, se registra y compra productos.  |
| **Administrador** | Gestiona el sistema, usuarios, productos y pedidos.           |

---

### 🧾 CASOS DE USO DEL CLIENTE

#### 1. Registrarse
- **Actor:** Cliente
- **Descripción:** El usuario crea una cuenta en el sistema.
- **Precondición:** No estar autenticado.
- **Flujo principal:**
  1. Accede al formulario de registro.
  2. Ingresa datos personales y de contacto.
  3. Confirma contraseña.
  4. Se crea el usuario en la base de datos.
- **Postcondición:** Usuario registrado y autenticado automáticamente (opcional).

#### 2. Iniciar sesión
- **Actor:** Cliente
- **Descripción:** Accede al sistema mediante su correo y contraseña.
- **Precondición:** Tener una cuenta registrada.
- **Postcondición:** Accede al panel de usuario o tienda.

#### 3. Ver catálogo de productos
- **Actor:** Cliente
- **Descripción:** Consulta productos disponibles con filtros.
- **Incluye:** Ver detalles de producto.
- **Postcondición:** Visualiza descripción, imágenes, precio y tallas.

#### 4. Agregar producto a favoritos
- **Actor:** Cliente
- **Descripción:** Guarda productos para revisarlos luego.
- **Precondición:** Estar autenticado.
- **Postcondición:** Producto guardado en su lista personal.

#### 5. Realizar pedido
- **Actor:** Cliente
- **Descripción:** Selecciona productos y los compra.
- **Precondición:** Estar autenticado y tener productos en el carrito.
- **Flujo principal:**
  1. Agrega productos al carrito.
  2. Revisa el resumen del pedido.
  3. Selecciona dirección y medio de pago.
  4. Confirma pedido.
- **Postcondición:** Pedido registrado y en estado "pendiente".

#### 6. Consultar historial de pedidos
- **Actor:** Cliente
- **Descripción:** Revisa pedidos pasados con sus estados.
- **Incluye:** Ver detalles del pedido.

#### 7. Editar perfil
- **Actor:** Cliente
- **Descripción:** Modifica su información personal.
- **Postcondición:** Cambios guardados exitosamente.

#### 8. Cerrar sesión
- **Actor:** Cliente
- **Descripción:** Finaliza su sesión de usuario.

---

### ⚙️ CASOS DE USO DEL ADMINISTRADOR

#### 9. Iniciar sesión como administrador
- **Actor:** Administrador
- **Descripción:** Accede al panel administrativo.
- **Precondición:** Tener credenciales válidas.

#### 10. Gestionar productos
- **Actor:** Administrador
- **Descripción:** Crea, edita y elimina productos.
- **Flujos incluidos:**
  - Agregar nuevo producto.
  - Editar información (nombre, precio, stock, imagen, talla).
  - Eliminar producto.

#### 11. Gestionar usuarios
- **Actor:** Administrador
- **Descripción:** Visualiza, desactiva o elimina usuarios.
- **Postcondición:** Base de usuarios actualizada.

#### 12. Gestionar pedidos
- **Actor:** Administrador
- **Descripción:** Visualiza pedidos entrantes.
- **Flujos incluidos:**
  - Ver pedidos por estado.
  - Cambiar estado del pedido: pendiente → en proceso → enviado → finalizado/cancelado.

#### 13. Ver reportes de ventas
- **Actor:** Administrador
- **Descripción:** Accede a estadísticas generales del sistema.
- **Opcional:** Exportar reportes en Excel o PDF.

#### 14. Cerrar sesión (Administrador)
- **Actor:** Administrador
- **Descripción:** Finaliza sesión segura del panel administrativo.


## Hacer al clonar
(Recordar tener la base de datos descargada con el mismo nombre)
1. Ingresar en la terminal : copy .env.example .env  y modificar el .env, añadir en app_key: base64:04lvCfjl/6uNeSV4r62X9A2lNYlDhR6OyCClrX7pKIM=
2. revisar que en el archivo .env este session_driver=File (no database, en caso que este database cambiarla.)
3. Crear una rama que lleve el modul/el nombre_de_la_persona
4. Dentro de VS ya con el proyecto abierto, ingresar el comando: ## composer install   Esto es necesario para los que clonamos el proyecto.
5. Ingresar el comando ## php artisan migrate para que las migraciones que ya estaban hechas funcionen.
6. Iniciar el servidor

## ⚙️ Instalación
```bash
## Configuración Básica

Configurar Nombre que salen en los commits
```ssh
	git config --global user.name "dasdo"
```
Configurar Email
```ssh	
	git config --global user.email dasdo1@gmail.com
```
Marco de colores para los comando
```ssh
	git config --global color.ui true
```

## Iniciando repositorio

Iniciamos GIT en la carpeta donde esta el proyecto
```ssh
	git init
```
Clonamos el repositorio de github o bitbucket
```ssh
	git clone <url>
```
Añadimos todos los archivos para el commit
```ssh
	git add .
```
Hacemos el primer commit
```ssh
	git commit -m "Texto que identifique por que se hizo el commit"
```
subimos al repositorio
```ssh
	git push origin master
```

## GIT CLONE


Clonamos el repositorio de github o bitbucket
```ssh
	git clone <url>
```
Clonamos el repositorio de github o bitbucket ?????
```ssh
	git clone <url> git-demo
```

## GIT ADD


Añadimos todos los archivos para el commit
```ssh
	git add .
```
Añadimos el archivo para el commit
```ssh
	git add <archivo>
```
Añadimos todos los archivos para el commit omitiendo los nuevos
```ssh
	git add --all 
```
Añadimos todos los archivos con la extensión especificada
```ssh
	git add *.txt
```
Añadimos todos los archivos dentro de un directorio y de una extensión especifica
```ssh
	git add docs/*.txt
```
Añadimos todos los archivos dentro de un directorios
```ssh
	git add docs/
```
## GIT COMMIT

Cargar en el HEAD los cambios realizados
```ssh
	git commit -m "Texto que identifique por que se hizo el commit"
```
Agregar y Cargar en el HEAD los cambios realizados
```ssh
	git commit -a -m "Texto que identifique por que se hizo el commit"
```
De haber conflictos los muestra
```ssh
	git commit -a 
```
Agregar al ultimo commit, este no se muestra como un nuevo commit en los logs. Se puede especificar un nuevo mensaje
```ssh
	git commit --amend -m "Texto que identifique por que se hizo el commit"
```
## GIT PUSH

Subimos al repositorio
```ssh
	git push <origien> <branch>
```
Subimos un tag
```ssh
	git push --tags
```
## GIT LOG

Muestra los logs de los commits
```ssh
	git log
```
Muestras los cambios en los commits
```ssh
	git log --oneline --stat
```
Muestra graficos de los commits
```ssh
	git log --oneline --graph
```
## GIT DIFF

Muestra los cambios realizados a un archivo
```ssh
	git diff
	git diff --staged
```
## GIT HEAD

Saca un archivo del commit
```ssh
	git reset HEAD <archivo>
```
Devuelve el ultimo commit que se hizo y pone los cambios en staging
```ssh
	git reset --soft HEAD^
```
Devuelve el ultimo commit y todos los cambios
```ssh
	git reset --hard HEAD^
```
Devuelve los 2 ultimo commit y todos los cambios
```ssh
	git reset --hard HEAD^^
```
Rollback merge/commit
```ssh
	git log
	git reset --hard <commit_sha>
```
## GIT REMOTE

Agregar repositorio remoto
```ssh
	git remote add origin <url>
```
Cambiar de remote
```ssh
	git remote set-url origin <url>
```
Remover repositorio
```ssh
	git remote rm <name/origin>
```
Muestra lista repositorios
```ssh
	git remote -v
```
Muestra los branches remotos
```ssh	
	git remote show origin
```
Limpiar todos los branches eliminados
```ssh
	git remote prune origin 
```
## GIT BRANCH

Crea un branch
```ssh
	git branch <nameBranch>
```
Lista los branches
```ssh
	git branch
```
Comando -d elimina el branch y lo une al master
```ssh
	git branch -d <nameBranch>
```
Elimina sin preguntar
```ssh
	git branch -D <nameBranch>
```
## GIT TAG

Muestra una lista de todos los tags
```ssh
	git tag
```
Crea un nuevo tags
```ssh
	git tag -a <verison> - m "esta es la versión x"
```
## GIT REBASE

Los rebase se usan cuando trabajamos con branches esto hace que los branches se pongan al día con el master sin afectar al mismo

Une el branch actual con el mastar, esto no se puede ver como un merge
```ssh
	git rebase
```
Cuando se produce un conflicto no das las siguientes opciones:

cuando resolvemos los conflictos --continue continua la secuencia del rebase donde se pauso
```ssh	
	git rebase --continue 
```
Omite el conflicto y sigue su camino
```ssh
	git rebase --skip
```
Devuelve todo al principio del rebase
```ssh
	git reabse --abort
```
Para hacer un rebase a un branch en especifico
```ssh	
	git rebase <nameBranch>
```
## OTROS COMANDOS

Lista un estado actual del repositorio con lista de archivos modificados o agregados
```ssh
	git status
```
Quita del HEAD un archivo y le pone el estado de no trabajado
```ssh
	git checkout -- <file>
```
Crea un branch en base a uno online
```ssh
	git checkout -b newlocalbranchname origin/branch-name
```
Busca los cambios nuevos y actualiza el repositorio
```ssh
	git pull origin <nameBranch>
```
Cambiar de branch
```ssh
	git checkout <nameBranch/tagname>
```
Une el branch actual con el especificado
```ssh
	git merge <nameBranch>
```
Verifica cambios en el repositorio online con el local
```ssh
	git fetch
```
Borrar un archivo del repositorio
```ssh
	git rm <archivo> 
```

## Fork

Descargar remote de un fork
```
	git remote add upstream <url>
```

Merge con master de un fork
```
	git fetch upstream
	git merge upstream/master
```
# 1. Borrar historial git
rm -rf .git

# 2. Inicializar un nuevo repo vacío
git init

# 3. Volver a conectar con GitHub
git remote add origin https://github.com/tuusuario/tu-repo.git

# 4. Agregar los archivos de nuevo
git add .

# 5. Hacer un primer commit nuevo
git commit -m "Primer commit limpio"

# 6. Subir forzado (elimina historial en GitHub también)
git push -f origin main