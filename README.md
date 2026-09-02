# Sistema de Retención de Aprendices (SPRAS)

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg> Introducción
El Sistema de Retención de Aprendices (SPRAS) es una herramienta web desarrollada en PHP utilizando el framework Laravel y bases de datos MySQL mediante MySQL Workbench . Está diseñado para optimizar, centralizar y automatizar los procesos de seguimiento y acompañamiento a aprendices en riesgo académico en el SENA , facilitando la coordinación institucional entre instructores, áreas de apoyo y el comité académico.

---

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> Datos del Proyecto
- **Programa**: Análisis y Desarrollo del Software (ADSO) 
- **Ficha**: 3230746 
- **Autores**: Jeimy Xiomara Jimenez Leguizamon y Edgar David Cárdenas Rubio 
- **Instructora**: Nidia Zoraida Nieto Hernández 
- **Repositorio Oficial**: [GitHub - retencionaprendices](https://github.com/jemyleguizamon-skz/retencionaprendices) 

---

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg> ¿Qué hace el sistema?
El sistema administra de manera integral el ciclo de vida del riesgo académico de los aprendices, permitiendo la verificación de roles, el procesamiento de formularios de inicio de sesión, el registro de aprendices por parte de instructores y las valoraciones de áreas de apoyo . Asimismo, genera listados automáticos, administra la gestión y visualización de archivos de seguimiento, aplica filtros de privacidad para mostrar únicamente el historial del profesional registrado y permite realizar búsquedas directas por nombre de aprendiz en la base de datos .

---

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg> Paso a paso de lo que hace el sistema

1. **Autenticación y Verificación de Rol**: 
   El usuario ingresa al sistema a través del formulario de inicio de sesión, donde se valida su identidad y su rol correspondiente (instructor, área de apoyo o comité académico) .

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

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Requerimientos Funcionales

1. El sistema realiza el proceso de verificación del usuario dependiendo de su rol (instructor, área de apoyo, comité académico) .
2. El sistema direcciona al usuario a su página correspondiente según el rol verificado .
3. El sistema procesa los datos de los formularios de inicio de sesión, registro de aprendices y registro de valoración .
4. El sistema genera automáticamente los listados basados en los datos registrados en los formularios .
5. El sistema almacena y visualiza los archivos de seguimiento del aprendiz mediante un listado .
6. El sistema muestra en el historial únicamente las valoraciones del profesional de apoyo registrado, ocultando las de otros compañeros .
7. El sistema implementa una barra de búsqueda para filtrar valoraciones por el nombre del aprendiz mediante consultas directas a la base de datos .
8. El sistema gestiona el almacenamiento y visualización de archivos adjuntos de seguimiento para cada valoración .
9. El sistema permite la asignación de aprendices a programas de formación mediante el registro de fichas vinculadas al instructor .

---

## <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg> Tecnologías Utilizadas
- **Backend**: PHP / Laravel 
- **Frontend**: Blade Templates, Bootstrap
- **Base de Datos**: MySQL / MySQL Workbench 
- **Control de Versiones**: Git & GitHub 