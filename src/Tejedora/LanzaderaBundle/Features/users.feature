#language: es
Característica: Administrar usuarios
  Para administrar los usuarios
  Como administrador de la aplicación
  Quiero poder ver un panel de administración

  Escenario: Ver listado de usuarios
    Dado estoy autenticado como administrador
    Y estoy en "/lanzadera"
    Cuando presiono "Usuarios"
    Entonces debo estar en "/lanzadera/usuarios"
    Y debo ver "Listado de usuarios"
