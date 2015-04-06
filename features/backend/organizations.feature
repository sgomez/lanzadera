#language: es
@organizations
Característica: Organizaciones
    Para llevar una gestión de las organizaciones
    Como administrador del mercao social
    Quiero poder administrar las entidades que venden en nuestra organización

    Antecedentes:
      Dado que existen los siguientes usuarios:
        | username  | password  | email                 | enabled | role        |
        | admin     | adminpw   | admin@latejedora.com  | 1       | ROLE_ADMIN  |
      Y que estoy autenticado como administrador
      Y existen las siguientes organizaciones:
        | name           | enabled |
        | Organización A | 1       |
        | Organización B | 1       |
        | Organización C | 1       |
        | Organización D | 1       |

    Escenario: Ver el listado de organizaciones
        Dado que estoy en la página del escritorio
        Cuando presiono listar las organizaciones
        Entonces debería estar en la página principal de organización
        Y debería ver 4 organizaciones en la lista

    Escenario: Buscar organizaciones
        Dado que estoy en la página principal de organización
        Cuando relleno "Nombre" con "Organización B"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de organización
        Y debería ver 1 organización en la lista

    Escenario: Acceder a los detalles de la organización desde el listado
        Dado que estoy en la página principal de organización
        Cuando presiono "Mostrar" junto a "Organización C"
        Entonces debería estar en la página de organización con nombre "Organización C"

    Escenario: Acceder al formulario de creación de usuarios
        Dado que estoy en la página principal de organización
        Y sigo "Agregar nuevo"
        Entonces debería estar en la página creación de organización

    Escenario: Enviar formulario vacío
        Dado que estoy en la página creación de organización
        Cuando presiono "Crear y editar"
        Entonces debería estar todavía en la página creación de organización
        Y debo ver "Por favor, indique el nombre de la organización."

    Escenario: Crear organización
        Dado que estoy en la página creación de organización
        Cuando relleno lo siguiente:
          | Nombre      | La Tejedora           |
          | Dirección   | Plaza de la Tejedora  |
          | Teléfono    | 555-123456            |
          | Email    | info@latejedora.com   |
          | Página web  | http://latejedora.com |
          | Activo      | 1                     |
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de organización
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "La Tejedora"

    Escenario: Acceder al formulario de edición de usuario desde el listado
        Dado que estoy en la página principal de organización
        Cuando presiono "Editar" junto a "Organización B"
        Entonces debería estar en la página edición de organización con nombre "Organización B"

    Escenario: Actualizar organización
        Dado que estoy en la página edición de organización con nombre "Organización A"
        Cuando relleno "Email" con "info@organizaciona.com"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de organización con nombre "Organización A"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Email" debe contener "info@organizaciona.com"

    Escenario: Borrar organización desde la página de edición
        Dado que estoy en la página edición de organización con nombre "Organización A"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de organización
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar organización desde el listado
        Dado que estoy en la página principal de organización
        Cuando presiono "Borrar" junto a "Organización A"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de organización
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Organización A"



