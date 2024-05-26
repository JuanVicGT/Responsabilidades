# Ruta de trabajo para desarrollar el sistema

## Dudas para la siguiente reunión
- ¿Ambos modulos comparten usuarios?
- Si comparten usuarios, ¿también comparten funciones?
    Por parte se mencionó el subir tareas, ¿eso aplica también a los usuario a
    quienes se les asignen las hojas de responsabilidades?.
- ¿Cómo manejan la re asignación de las responsabilidades?
    Cambian completamente la hoja, o solo se transfiere el item a la próxima hoja.
- Todos los usuarios creados, ¿tendrían acceso al sistema o habrán algunos creados solo
    para asignarles hojas de responsabilidades?
    Si fuera el caso, se podría plantear tener usuarios y en una tabla por separado a los
    empleados.
- Los usuarios que pueda ingresar al sistema, ¿pueden actualizar ellos mismos todos sus datos, 
    o solo algunos?.

## 1. Credenciales
Se detecto que en la municipalidad no emplean el correo de los colaboradores, por lo que se debe dejar como un campo opcional y que no sea tomado en cuenta para el inició de sesión.

En su lugar se usara un campo llamado username, para el inicio de sesión.

## 2. Roles y permisos
Se debe agregar una función para gestionar Roles y Permisos, esto debido a que varias personas podrán tener acceso al sistema, aunque tengan diferentes puestos.

Actualmente solo existe un único Rol

## 3. Modulos
Se debe detectar los distintos modulos que tenrá el sistema, por el momento solo se ha hablado de las hojas de responsabilidades y habrá una reunión para determinar RRHH