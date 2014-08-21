#language: es
@criteria
Característica: Criterios
    Para poder determinar las características que pueden reunir organizaciones y productos
    Como administrador del mercao social
    Quiero poder crear criterios de criterio

    Antecedentes:
        Dado que existen los siguientes usuarios:
            | username  | password  | email                 | enabled | role        |
            | admin     | adminpw   | admin@latejedora.com  | 1       | ROLE_ADMIN  |
        Y que estoy autenticado como administrador
        Y existen las siguientes clasificaciones:
            | nombre            | descripción                  | umbral |
            | Clasificación A   | Agrupa Propiedades de tipo A | 60     |
            | Clasificación B   | Agrupa Propiedades de tipo B | 75     |
            | Clasificación C   | Agrupa Propiedades de tipo C | 88     |
            | Clasificación D   | Agrupa Propiedades de tipo D | 93     |
        Y existen los siguientes criterios:
            | nombre            | descripción                           | tipo          | clasificación   |
            | Criterio A        | Describe como se cumple el criterio A | Organización  | Clasificación A |
            | Criterio B        | Describe como se cumple el criterio B | Organización  | Clasificación B |
            | Criterio C        | Describe como se cumple el criterio C | Producto      | Clasificación A |
            | Criterio D        | Describe como se cumple el criterio D | Producto      | Clasificación B |

    Escenario: Ver el listado de criterios
        Dado que estoy en la página del escritorio
        Cuando presiono listar los criterios
        Entonces debería estar en la página principal de criterio
        Y debería ver 4 criterios en la lista

    Escenario: Buscar criterios
        Dado que estoy en la página principal de criterio
        Cuando relleno "Nombre" con "Criterio B"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de criterio
        Y debería ver 1 criterio en la lista

    Escenario: Acceder a los detalles de la criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Mostrar" junto a "Criterio C"
        Entonces debería estar en la página de criterio con nombre "Criterio C"

    Escenario: Acceder al formulario de creación de criterios
        Dado que estoy en la página principal de criterio
        Y sigo "Agregar nuevo"
        Entonces debería estar en la página creación de criterio

    Escenario: Enviar formulario vacío
        Dado que estoy en la página creación de criterio
        Cuando presiono "Crear y editar"
        Entonces debería estar todavía en la página creación de criterio
        Y debo ver "Por favor, indique el nombre del criterio."

    Escenario: Crear criterio
        Dado que estoy en la página creación de criterio
        Cuando relleno lo siguiente:
            | Nombre        | Tipo de actividad                                     |
            | Descripción   | Describe el tipo de actividad de la organización      |
            | Organización  | 1                                                     |
        Y selecciono "Clasificación B" de "Clasificación"
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Tipo de actividad"

    Escenario: Acceder al formulario de edición de criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Editar" junto a "Criterio B"
        Entonces debería estar en la página edición de criterio con nombre "Criterio B"

    Escenario: Actualizar criterio
        Dado que estoy en la página edición de criterio con nombre "Criterio A"
        Cuando relleno "Descripción" con "Descripción actualizada"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de criterio con nombre "Criterio A"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Descripción" debe contener "Descripción actualizada"

    Escenario: Borrar criterio desde la página de edición
        Dado que estoy en la página edición de criterio con nombre "Criterio A"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Borrar" junto a "Criterio A"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Criterio A"

