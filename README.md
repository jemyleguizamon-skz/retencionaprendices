# Sistema de Retención de Aprendices (SPRAS)

## 📌 Introducción
El Sistema de Retención de Aprendices (SPRAS) es una herramienta web desarrollada en PHP utilizando el framework Laravel y bases de datos MySQL mediante MySQL Workbench . Está diseñado para optimizar, centralizar y automatizar los procesos de seguimiento y acompañamiento a aprendices en riesgo académico en el SENA , facilitando la coordinación institucional entre instructores, áreas de apoyo y el comité académico.

---

## 👥 Datos del Proyecto
- **Programa**: Análisis y Desarrollo del Software (ADSO) 
- **Ficha**: 3230746 
- **Autores**: Jeimy Xiomara Jimenez Leguizamon y Edgar David Cárdenas Rubio 
- **Instructora**: Nidia Zoraida Nieto Hernández 
- **Repositorio Oficial**: [GitHub - retencionaprendices](https://github.com/jemyleguizamon-skz/retencionaprendices) 

---

## ⚙️ ¿Qué hace el sistema?
El sistema administra de manera integral el ciclo de vida del riesgo académico de los aprendices, permitiendo la verificación de roles, el procesamiento de formularios de inicio de sesión, el registro de aprendices por parte de instructores y las valoraciones de áreas de apoyo . Asimismo, genera listados automáticos, administra la gestión y visualización de archivos de seguimiento, aplica filtros de privacidad para mostrar únicamente el historial del profesional registrado y permite realizar búsquedas directas por nombre de aprendiz en la base de datos .

---

## 👣 Paso a paso de lo que hace el sistema

1. **Autenticación y Verificación de Rol**: 
   El usuario ingresa al sistema a través del formulario de inicio de sesión, donde se valida su identidad y su rol correspondiente (instructor, área de apoyo o comité académico), si en caso de no estar registrado, podra hacer el debido preoceso para la creacion del usuario y su rol.

2. **Direccionamiento Automático**: 
   Una vez verificado el perfil, el sistema redirige de forma automática al usuario hacia la página y panel de control asignado a su rol .

3. **Registro de Datos e Interacción**: 
   - El **Instructor** accede al formulario para registrar aprendices y asociarlos a los programas de formación mediante fichas .
   - El **Área de Apoyo** utiliza el formulario de registro de valoración para ingresar los detalles del caso y adjuntar la documentación requerida .

4. **Procesamiento y Listado Automático**: 
   La aplicación procesa los datos ingresados en los formularios, los almacena de forma estructurada en la base de datos MySQL y genera de manera automática los listados correspondientes en las vistas .

5. **Filtrado y Consulta de Historiales**: 
   - El sistema muestra en la tabla de historial únicamente las valoraciones pertenecientes al profesional de apoyo que ha iniciado sesión, ocultando los registros de otros compañeros .
   - Los usuarios pueden utilizar la barra de búsqueda integrada para filtrar las valoraciones guardadas mediante consultas directas basadas en el nombre del aprendiz .

6. **Gestión Documental**: 
   El sistema almacena y visualiza de forma organizada los archivos adjuntos de seguimiento para cada registro de valoración .

---

## 📋 Requerimientos Funcionales

1. El sistema realiza el proceso de verificación del usuario dependiendo de su rol (instructor, área de apoyo, comité académico)
2. El sistema direcciona al usuario a su página correspondiente según el rol verificado .
3. El sistema procesa los datos de los formularios de inicio de sesión, registro de aprendices y registro de valoración .
4. El sistema genera automáticamente los listados basados en los datos registrados en los formularios .
5. El sistema almacena y visualiza los archivos de seguimiento del aprendiz mediante un listado .
6. El sistema muestra en el historial únicamente las valoraciones del profesional de apoyo registrado, ocultando las de otros compañeros .
7. El sistema implementa una barra de búsqueda para filtrar valoraciones por el nombre del aprendiz mediante consultas directas a la base de datos .
8. El sistema gestiona el almacenamiento y visualización de archivos adjuntos de seguimiento para cada valoración .
9. El sistema permite la asignación de aprendices a programas de formación mediante el registro de fichas vinculadas al instructor .

---

## 🛠️ Tecnologías Utilizadas
- **Backend**: PHP / Laravel 
- **Frontend**: Blade Templates, Bootstrap
- **Base de Datos**: MySQL / MySQL Workbench 
- **Control de Versiones**: Git & GitHub 

---