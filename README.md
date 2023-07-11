# glossary_tooltip

# Para instalar el módulo "Glossary Tooltip" en Drupal y utilizar el glosario, puedes seguir los siguientes pasos:

# Descarga el módulo:

Ve al repositorio de GitHub del proyecto: https://github.com/Aldoarevalo/glossary_tooltip.git
Haz clic en el botón "Code" y luego en "Download ZIP" para descargar el archivo ZIP del módulo.
Extrae el archivo ZIP descargado en el directorio "modules" de tu instalación de Drupal. Deberás crear una carpeta nueva llamada "glossary_tooltip" y colocar allí los archivos del módulo.

Renombra el archivo "glossary_tooltip.module.example" a "glossary_tooltip.module".

# Activa el módulo:

Inicia sesión como administrador en tu sitio Drupal.
Ve a la página "Gestión de módulos" (/admin/modules) o accede a través del menú de administración "Extend".
Busca "Glossary Tooltip" en la lista de módulos y marca la casilla junto a él.
Haz clic en el botón "Guardar configuración" para activar el módulo.

# Configura el módulo:

Después de activar el módulo, deberás configurarlo para definir los términos del glosario y sus descripciones.
Ve a la página de configuración del módulo "Glossary Tooltip" (/admin/config/content/glossary-tooltip) o accede a través del menú de administración "Configuración" > "Glossary Tooltip".
En esta página, podrás agregar nuevos términos y definir sus descripciones.
Haz clic en el botón "Agregar término" para agregar un nuevo término al glosario.
Utiliza el glosario en tu contenido:

Después de configurar los términos del glosario, podrás utilizarlo en el contenido de tu sitio.
Cuando redactes un contenido (página, artículo, etc.), puedes usar las etiquetas HTML <glossary> y <tooltip> para resaltar los términos del glosario.
Por ejemplo, puedes escribir <glossary>Término</glossary> para resaltar un término del glosario en el contenido.
Si deseas mostrar una descripción emergente (tooltip) para el término, usa la etiqueta <tooltip> en lugar de <glossary>.
El módulo procesará las etiquetas y resaltará los términos del glosario en el contenido.

# se puede habrir el modulo directamente desde el enlace
http://localhost/grupal/Drupal/admin/structure/glossary-term
