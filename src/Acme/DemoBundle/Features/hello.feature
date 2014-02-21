#language: es
Característica: Utilizar desarrollo orientado a comportamiento
  Para comprobar que Behat está bien configurado
  Como programador de la aplicación
  Quiero probar la demo de Symfony

  Escenario: Probar la demo 'Hello World'
    Dado estoy en "/demo"
    Y sigo "Hello World"
    Entonces debo estar en "/demo/hello/World"
    Y debo ver "Hello World!"

  Escenario: Probar la demo 'Hello World' con la palabra Moto
    Dado estoy en "/demo"
    Y sigo "Hello World"
    Entonces debo estar en "/demo/hello/World"
    Y debo ver "Hello Moto!"