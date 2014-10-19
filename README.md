# Lanzadera

Lanzadera es un gestor de catálogo para Mercados Sociales distribuido bajo Licencia GPLv3.

Permite gestionar un catálogo de productos y clasificarlos por indicadores, de tal manera que los potenciales
clientes puedan comprobar qué productos siguen mejor los criterios marcados por el Mercado Social.

# Instalación rápida

_En construcción_

Tras descargar y descomprimir el proyecto ejecutar las siguientes órdenes:

```bash
$ git clone https://github.com/sgomez/lanzadera.git lanzadera
$ cd lanzadera
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
$ php app/console lanzadera:install --env=prod
```

Este proyecto tiene dos entornos más (dev y test). Si se crean pueden usarse fixtures (en dev) o las pruebas de
comportamiento (con behat).
