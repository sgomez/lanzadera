#language: es
@login
Característica: Iniciar sesión
  Para poder usar la aplicación
  Como usuario registrado y habilitado
  Quiero poder identificarme

  Antecedentes:
    Dado que existen los siguientes usuarios:
      | username  | password  | email                 | enabled | role        |
      | admin     | adminpw   | admin@latejedora.com  | 1       | ROLE_ADMIN  |
      | sergio    | sergiopw  | sergio@uco.es         | 1       | ROLE_USER   |
      | johndoe   | johndoepw | johndoe@latejedora.com| 0       | ROLE_ADMIN  |

  Escenario: Identificarse como administrador
    Dado estoy en "/login"
    Cuando relleno "username" con "admin"
    Y relleno "password" con "adminpw"
    Y presiono "Entrar"
    Entonces debo estar en la página del escritorio

  Escenario: Iniciar sesión como un usuario no existente
    Dado estoy en "/login"
    Cuando relleno "username" con "anonymous"
    Y relleno "password" con "anonymous"
    Y presiono "Entrar"
    Entonces debo estar en "/login"
    Y debo ver "Nombre de usuario o Contraseña inválido"

  Escenario: Iniciar sesión como un usuario no habilitado
    Dado estoy en "/login"
    Cuando relleno "username" con "johndoe"
    Y relleno "password" con "johndoepw"
    Y presiono "Entrar"
    Entonces debo estar en "/login"
    Y debo ver "Cuenta de usuario desactivada"
