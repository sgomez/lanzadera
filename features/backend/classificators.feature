#language: es
@classificators
Característica: Clasificación
    Para poder determinar si los productos cumplen con características de calidad
    Como administrador del mercao social
    Quiero poder crear grupos de clasificación de productos

    Antecedentes:
        Dado que estoy autenticado como administrador
        Y existen las siguientes clasificaciones:
            | nombre            | descripción                  | umbral |
            | Clasificación A   | Agrupa Propiedades de tipo A | 60     |
            | Clasificación B   | Agrupa Propiedades de tipo B | 75     |
            | Clasificación C   | Agrupa Propiedades de tipo C | 88     |
            | Clasificación D   | Agrupa Propiedades de tipo D | 93     |

    Escenario: Ver el listado de clasificadores
        Dado que estoy en la página del escritorio
        Cuando presiono listar los clasificadores
        Entonces debería estar en la página principal de clasificación
        Y debería ver 4 clasificadores en la lista

    Escenario: Buscar clasificadores
        Dado que estoy en la página principal de clasificación
        Cuando relleno "Nombre" con "Clasificación B"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de clasificación
        Y debería ver 1 clasificación en la lista

    Escenario: Acceder a los detalles de la clasificación desde el listado
        Dado que estoy en la página principal de clasificación
        Cuando presiono "Mostrar" junto a "Clasificación C"
        Entonces debería estar en la página de clasificación con nombre "Clasificación C"

    Escenario: Acceder al formulario de creación de clasificadores
        Dado que estoy en la página principal de clasificación
        Y sigo "Agregar nuevo"
        Entonces debería estar en la página creación de clasificación

    Escenario: Enviar formulario vacío
        Dado que estoy en la página creación de clasificación
        Cuando presiono "Crear y editar"
        Entonces debería estar todavía en la página creación de clasificación
        Y debo ver "Por favor, indique el nombre de la clasificación."

    Escenario: Crear clasificador
        Dado que estoy en la página creación de clasificación
        Cuando relleno lo siguiente:
            | Nombre      | Comercio Justo        |
            | Descripción | Descripción           |
            | Umbral      | 60                    |
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de clasificación
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Comercio Justo"

    Escenario: Acceder al formulario de edición de clasificación desde el listado
        Dado que estoy en la página principal de clasificación
        Cuando presiono "Editar" junto a "Clasificación B"
        Entonces debería estar en la página edición de clasificación con nombre "Clasificación B"

    Escenario: Actualizar clasificación
        Dado que estoy en la página edición de clasificación con nombre "Clasificación A"
        Cuando relleno "Umbral" con "75"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de clasificación con nombre "Clasificación A"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Umbral" debe contener "75"

    Escenario: Borrar clasificación desde la página de edición
        Dado que estoy en la página edición de clasificación con nombre "Clasificación A"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de clasificación
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar clasificación desde el listado
        Dado que estoy en la página principal de clasificación
        Cuando presiono "Borrar" junto a "Clasificación A"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de clasificación
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Clasificación A"

