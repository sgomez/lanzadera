#language: es
@users
Característica: Administrar usuarios
  Para administrar los usuarios
  Como administrador de la aplicación
  Quiero poder ver un panel de administración

  Antecedentes:

    Dado que existen los siguientes usuarios:
      | username  | password  | email                 | enabled | role        |
      | admin     | adminpw   | admin@secret.com      | 1       | ROLE_ADMIN  |
      | sergio    | sergiopw  | sergio@secret.com     | 1       | ROLE_USER   |
      | johndoe   | johndoepw | johndoe@secret.com    | 0       | ROLE_ADMIN  |
      Y que estoy autenticado como administrador

  Escenario: Ver listado de todos los usuarios
    Dado que estoy en la página del escritorio
    Cuando presiono listar los usuarios
    Entonces debería estar en la página principal de usuario
    Y debería ver 3 usuarios en la lista

  Escenario: Buscar usuarios
    Dado que estoy en la página principal de usuario
    Cuando relleno "Nombre de usuario" con "sergio"
    Y presiono "Filtrar"
    Entonces debería estar en la página principal de usuario
    Y debería ver 1 usuario en la lista

  Escenario: Acceder a los detalles del usuario desde el listado
    Dado que estoy en la página principal de usuario
    Cuando presiono "Mostrar" junto a "sergio"
    Entonces debería estar en la página de usuario con identificador "sergio"

  Escenario: Acceder al formulario de creación de usuarios
    Dado que estoy en la página principal de usuario
    Y sigo "Agregar nuevo"
    Entonces debería estar en la página creación de usuario

  Escenario: Enviar formulario vacío
    Dado que estoy en la página creación de usuario
    Cuando presiono "Crear y editar"
    Entonces debería estar todavía en la página creación de usuario
    Y debo ver "Por favor, ingrese un nombre de usuario"

  Escenario: Crear usuario
    Dado que estoy en la página creación de usuario
    Cuando relleno lo siguiente:
      | Nombre de usuario               | testuser          |
      | Dirección de correo electrónico | testuser@test.com |
      | Contraseña                      | ********          |
    Y presiono "Crear y regresar al listado"
    Entonces debería estar en la página principal de usuario
    Y debo ver "Elemento creado satisfactoriamente"
    Y debo ver "testuser@test.com"

  Escenario: Acceder al formulario de edición de usuario desde el listado
    Dado que estoy en la página principal de usuario
    Cuando presiono "Editar" junto a "sergio"
    Entonces debería estar en la página edición de usuario con identificador "sergio"

  Escenario: Actualizar usuario
    Dado que estoy en la página edición de usuario con identificador "sergio"
    Cuando relleno "Dirección de correo electrónico" con "sergio@nuevomail.com"
    Y presiono "Actualizar"
    Entonces debería estar en la página edición de usuario con identificador "sergio"
    Y debo ver "Elemento actualizado satisfactoriamente."
    Y el campo "Dirección de correo electrónico" debe contener "sergio@nuevomail.com"

  Escenario: Borrar usuario desde la página de edición
    Dado que estoy en la página edición de usuario con identificador "sergio"
    Cuando sigo "Borrar"
    Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
    Cuando presiono "Sí, borrar"
    Entonces debería estar en la página principal de usuario
    Y debo ver "Elemento eliminado satisfactoriamente."

  Escenario: Borrar usuario desde el listado
    Dado que estoy en la página principal de usuario
    Cuando presiono "Borrar" junto a "johndoe"
    Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
    Cuando presiono "Sí, borrar"
    Entonces debería estar en la página principal de usuario
    Y debo ver "Elemento eliminado satisfactoriamente."
    Pero no debo ver "johndoe"


