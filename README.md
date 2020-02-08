# #NuestroPresupuesto

Es un proyecto para facilitar la visualización y análisis histórico de los presupuestos locales para la ciudadanía.  El proyecto está diseñado desde Jalisco, México.

###  Características
- Visualización de treemap interactivo de una versión del presupuesto, por objeto de gasto, programas presupuestales y unidades responsables.

###  Próximos pasos
- Visualizaciones comparativas de históricos presupuestales.
- Agrupación del presupuesto por temáticas
- Rastreabilidad de unidades responsables que cambian de nombre, unidad presupuestal, o que se unen o dividen.

### Instalación
1. Montar en un servidor MySQL la base de datos contenida en clases/modelos/bdd.sql
2. Crear el archivo clases/modelos/config.php con los datos de la conexión a la base de datos, utilizar como modelo el archivo config.example.php


### Uso
- Crear los archivos JSON para la visualización deseada y guardarlos en una URL pública
- Añadir la visualización a la tabla Visualizaciones
