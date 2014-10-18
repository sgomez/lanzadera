#language: es
@criteria
Característica: Criterios
    Para poder determinar las características que pueden reunir organizaciones y productos
    Como administrador del mercao social
    Quiero poder crear criterios de criterio

    Antecedentes:
        Dado que estoy autenticado como administrador
        Y existen las siguientes clasificaciones:
            | nombre        | umbral |
            | Sociales      | 60     |
            | Ambientales   | 75     |
            | Comerciales   | 88     |
        Y existen los siguientes criterios:
            | nombre                            | tipo          | clasificación   |
            | Producción ecológica              | Producto      | Ambientales     |
            | Origen del producto               | Producto      | Ambientales     |
            | Militancia en el mercao social    | Organización  | Sociales        |
            | Respuesta a la creación de empleo | Organización  | Sociales        |
        Y el criterio "Producción ecológica" tiene los siguientes indicadores:
            | nombre    | valor |
            | Bajo      | 4     |
            | Medio     | 8     |
            | Alto      | 12    |
            | Muy alto  | 16    |
        Y el criterio "Origen del producto" tiene los siguientes indicadores:
            | nombre      | valor |
            | Extranjero  | 4     |
            | Andalucía   | 8     |
            | España      | 12    |
            | Córdoba     | 16    |

    Escenario: Ver el listado de criterios
        Dado que estoy en la página del escritorio
        Cuando presiono listar los criterios
        Entonces debería estar en la página principal de criterio
        Y debería ver 4 criterios en la lista

    Escenario: Buscar criterios
        Dado que estoy en la página principal de criterio
        Cuando relleno "Nombre" con "Producción ecológica"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de criterio
        Y debería ver 1 criterio en la lista

    Escenario: Acceder a los detalles de la criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Mostrar" junto a "Origen del producto"
        Entonces debería estar en la página de criterio con nombre "Origen del producto"

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
            | Organización  | organization                                          |
        Y selecciono "Sociales" de "Clasificador"
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Tipo de actividad"

    Escenario: Acceder al formulario de edición de criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Editar" junto a "Militancia en el mercao social"
        Entonces debería estar en la página edición de criterio con nombre "Militancia en el mercao social"

    Escenario: Actualizar criterio
        Dado que estoy en la página edición de criterio con nombre "Respuesta a la creación de empleo"
        Cuando relleno "Descripción" con "Descripción actualizada"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de criterio con nombre "Respuesta a la creación de empleo"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Descripción" debe contener "Descripción actualizada"

    @javascript
    Escenario: Crear nuevo indicador
        Dado que estoy en la página edición de criterio con nombre "Producción ecológica"
        Cuando sigo "Añadir indicador"
        Y relleno un nuevo indicador "Muy bajo" con el valor "2"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de criterio con nombre "Producción ecológica"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y debo ver el indicador "Muy bajo" con valor "2"

    @javascript
    Escenario: Crear un nuevo indicador con un valor repetido
        Dado que estoy en la página edición de criterio con nombre "Producción ecológica"
        Cuando sigo "Añadir indicador"
        Y relleno un nuevo indicador "Muy bajo" con el valor "4"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de criterio con nombre "Producción ecológica"
        Y debo ver "Se ha producido un error durante la actualización del elemento."
        Y debo ver "Este valor ya se ha utilizado."

    Escenario: Borrar criterio desde la página de edición
        Dado que estoy en la página edición de criterio con nombre "Respuesta a la creación de empleo"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar criterio desde el listado
        Dado que estoy en la página principal de criterio
        Cuando presiono "Borrar" junto a "Respuesta a la creación de empleo"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de criterio
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Respuesta a la creación de empleo"

