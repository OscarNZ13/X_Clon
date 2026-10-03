# 🐦 X Clon

Clon básico de la red social X (Twitter) hecho en PHP con el patrón **MVC**.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=flat-square&logo=css3&logoColor=white)

## ✨ Funcionalidades

- Registro, inicio y cierre de sesión.
- Publicar tweets.
- Seguir a otros usuarios y ver un **feed** con lo que publican.
- Perfil de usuario editable y página de usuarios.

## 📁 Estructura

```
Controller/   lógica de cada acción (login, tweets, perfil...)
Model/        acceso a datos
View/         páginas
Db/           conexión a la base de datos
db_x.sql      script de la base de datos
```

## 🚀 Cómo correrlo

1. Requisitos: PHP y MySQL (por ejemplo con XAMPP).
2. Importá `db_x.sql` en MySQL.
3. Ajustá los datos de conexión en la carpeta `Db/`.
4. Copiá el proyecto en `htdocs` y abrí `View/index.php`.

## 👥 Equipo

Proyecto universitario en equipo. Ver [colaboradores](../../graphs/contributors).
