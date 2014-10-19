#language: es
@tags
Característica: Etiquetas
    Para poder hacer mejores búsquedas entre los productos por etiquetas
    Como administrador del mercao social
    Quiero poder etiquetarlos semánticamente

    Antecedentes:
        Dado que estoy autenticado como administrador
        Y existen las siguientes taxonomías:
            | nombre          | id          |
            | Categoría       | Category    |
            | Etiqueta        | Tag         |
        Y la taxonomía "Tag" tiene los siguientes elementos:
            | Etiqueta A      |
            | Etiqueta B      |
            | Etiqueta C      |
            | Etiqueat D      |
            | Etiqueta E      |

        Escenario: Ver el listado de etiquetas
            Dado que estoy en la página del escritorio
            Cuando presiono listar las etiquetas
            Entonces debería estar en la página principal de etiqueta
            Y debería ver 5 etiquetas en la lista

        Escenario: Buscar etiquetas
            Dado que estoy en la página principal de etiqueta
            Cuando relleno "Nombre" con "Etiqueta B"
            Y presiono "Filtrar"
            Entonces debería estar en la página principal de etiqueta
            Y debería ver 1 etiqueta en la lista

        Escenario: Acceder a los detalles de la etiqueta desde el listado
            Dado que estoy en la página principal de etiqueta
            Cuando presiono "Mostrar" junto a "Etiqueta C"
            Entonces debería estar en la página de etiqueta con nombre "Etiqueta C"

        Escenario: Acceder al formulario de creación de etiquetas
            Dado que estoy en la página principal de etiqueta
            Y sigo "Agregar nuevo"
            Entonces debería estar en la página creación de etiqueta

        Escenario: Enviar formulario vacío
            Dado que estoy en la página creación de etiqueta
            Cuando presiono "Crear y editar"
            Entonces debería estar todavía en la página creación de etiqueta
            Y debo ver "Por favor, indique el nombre de la etiqueta."

        Escenario: Crear etiqueta
            Dado que estoy en la página creación de etiqueta
            Cuando relleno lo siguiente:
            | Nombre      | Etiqueta F        |
            Y presiono "Crear y regresar al listado"
            Entonces debería estar en la página principal de etiqueta
            Y debo ver "Elemento creado satisfactoriamente"
            Y debo ver "Etiqueta F"

        Escenario: Acceder al formulario de edición de etiqueta desde el listado
            Dado que estoy en la página principal de etiqueta
            Cuando presiono "Editar" junto a "Etiqueta B"
            Entonces debería estar en la página edición de etiqueta con nombre "Etiqueta B"

        Escenario: Actualizar etiqueta
            Dado que estoy en la página edición de etiqueta con nombre "Etiqueat D"
            Cuando relleno "Nombre" con "Etiqueta D"
            Y presiono "Actualizar"
            Entonces debería estar en la página edición de etiqueta con nombre "Etiqueta D"
            Y debo ver "Elemento actualizado satisfactoriamente."
            Y el campo "Nombre" debe contener "Etiqueta D"

        Escenario: Borrar etiqueta desde la página de edición
            Dado que estoy en la página edición de etiqueta con nombre "Etiqueta A"
            Cuando sigo "Borrar"
            Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
            Cuando presiono "Sí, borrar"
            Entonces debería estar en la página principal de etiqueta
            Y debo ver "Elemento eliminado satisfactoriamente."

        Escenario: Borrar etiqueta desde el listado
            Dado que estoy en la página principal de etiqueta
            Cuando presiono "Borrar" junto a "Etiqueta E"
            Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
            Cuando presiono "Sí, borrar"
            Entonces debería estar en la página principal de etiqueta
            Y debo ver "Elemento eliminado satisfactoriamente."
            Pero no debo ver "Etiqueta E"

