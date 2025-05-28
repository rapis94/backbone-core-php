Funcionamiento básico -
IMPORTANTE RECORDAR RENOMBRAR EL ARCHIVO "htaccess" a ".htaccess"
El sistema cuenta con rutas, las cuales son privadas, salvo que se creen dentro del directorio routes/public

Todas las solicitudes son desviadas por el htaccess hacia "routes"

Las rutas privadas deben pasar la autenticación JWT para ejecutarse.

El archivo Core.php se encarga de el enrutamiento, mientras el que backbone.php se encarga de la conexión con la DB.

Se recomienda el uso de variables de entorno para mayor se guridad de los datos sensibles


