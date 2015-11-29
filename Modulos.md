# Introducción #

Core9 divide las diferentes secciones de una aplicación en "módulos". Por poner un ejemplo, imaginemos que estamos haciendo una aplicación de correo electrónico para la Intranet de nuestra empresa. Necesitaremos varios "módulos" o "secciones", por ejemplo una para el correo (recibido, enviado, archivado, eliminado, etc) y otra para la agenda de contactos.

Aquí es donde entran en juego los módulos.

# Organizando nuestra aplicación #

Core9 se basa en el concepto de que una aplicación bien organizada es más fácil de mantener y utilizar. Los módulos sirven precisamente para eso, pero sin una estructura clara y definida sirven más bien de poco.

Lo primero que debemos hacer es pensar cómo vamos a organizar nuestra aplicación. Volviendo al ejemplo anterior, tendremos una pantalla con todos los correos (que pueden filtrarse según su "estado": enviados, recibidos, etc) y otra pantalla para organizar nuestros contactos.

Estas dos "pantallas" constituirán dos módulos en Core9.

Para ello, creamos, bajo el directorio **/modules**, una carpeta para cada uno: **correo** y **contactos**. Dentro de cada directorio crearemos dos ficheros **.php** llamados **index.php**. Ya está. Ya tenemos nuestros módulos.

Cuando ejecutemos **index.php?mod=correo** o **index.php?mod=contactos** Core9 irá automáticamente a buscar el fichero **index.php** dentro de los directorios **correo** o **contactos** y los ejecutará. Cada uno de estos ficheros se llama **acción** dentro de Core9.

Dentro de estos ficheros podemos definir diferentes funcionalidades según nuestras necesidades. Personalmente los uso únicamente para cargar información que luego asigno a la interfaz HTML, pero eso lo explicaremos en la siguiente página.

# Consideraciones #

En un módulo podemos tener varios ficheros a la vez. Así, podríamos crear un fichero **/contactos/index.php** para la lista de contactos y **/contactos/nuevo.php** para la página de nuevo contacto. Para acceder a estos ficheros adicionales usamos el argumento **accion**. Por ejemplo:

index.php?mod=contactos&accion=nuevo

Nótese que si no especificamos el argumento **accion** Core9 automáticamente buscará la acción **index**.

# mod\_rewrite #

Core9 incluye de serie un fichero .htaccess configurado para convertir las URL del navegador a la sintaxis de **index.php**. De esta forma:

http://miweb.com/contactos/nuevo se convertirá automáticamente en http://miweb.com/index.php?mod=contactos&accion=nuevo, cosa que queda bastante más elegante.

Los parámetros adicionales simplemente se asignan detrás de la cadena, así:

http://miweb.com/contactos/ficha/&id=1 equivale a http://miweb.com/index.php?mod=contactos&accion=ficha&id=1.

Recuerda habilitar el **mod\_rewrite** en tu configuración de Apache y activar el AllowOverride All en el directorio donde resida tu aplicación Core9 para que funcione correctamente.