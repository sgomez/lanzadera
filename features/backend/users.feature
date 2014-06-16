#language: es
@users
Característica: Administrar usuarios
  Para administrar los usuarios
  Como administrador de la aplicación
  Quiero poder ver un panel de administración

  Antecedentes:
    Dado que existen los siguientes usuarios:
      | username  | password  | email                 | enabled | role        |
      | admin     | adminpw   | admin@latejedora.com  | 1       | ROLE_ADMIN  |
      | sergio    | sergiopw  | sergio@uco.es         | 1       | ROLE_USER   |
      | johndoe   | johndoepw | johndoe@latejedora.com| 0       | ROLE_ADMIN  |

  Escenario: Ver listado de usuarios
    Dado que estoy autenticado como "admin"
    Cuando estoy en el panel de administración
    Y presiono "Listar" en el bloque "Usuarios"
    Entonces debo ver "Lista de usuarios"
