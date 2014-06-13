#language: es
@usuarios
Característica: Administrar usuarios
  Para administrar los usuarios
  Como administrador de la aplicación
  Quiero poder ver un panel de administración

  Escenario: Ver listado de usuarios
    Dado que estoy autenticado como "admin"
    Cuando voy a "/dashboard"
    Y presiono "Listar" en el bloque "Usuarios"
    Entonces debo ver "Lista de usuarios"
