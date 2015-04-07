#language: es
@categories
Característica: Categorías
    Para poder clasificar los productos por categorías
    Como administrador del mercao social
    Quiero poder crear y gestionar categorías jerarquicas

    Antecedentes:
        Dado que estoy autenticado como administrador
        Y existen las siguientes categorías:
            | Categoría A > Categoría A.1 > Categoría A.1.1 |
            | Categoría B > Categoría B.1                   |
            | Categoría C > Categoría C.1                   |

    Escenario: Ver el listado de categorías
        Dado que estoy en la página del escritorio
        Cuando presiono listar las categorías
        Y sigo "Lista"
        Entonces debería estar en la página principal de categoría
        Y debería ver 8 categorías en la lista

    Escenario: Buscar categorías
        Dado que estoy en la página principal de categoría
        Cuando relleno "Nombre" con "Categoría B"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de categoría
        Y debería ver 2 categorías en la lista

    Escenario: Acceder al formulario de creación de categorías
        Dado que estoy en la página principal de categoría
        Y sigo "Agregar nuevo"
        Entonces debería estar en la página creación de categoría

    Escenario: Enviar formulario vacío
        Dado que estoy en la página creación de categoría
        Cuando presiono "Crear y editar"
        Entonces debería estar todavía en la página creación de categoría
        Y debo ver "Se ha producido un error durante la creación del elemento."

    Escenario: Crear clasificador
        Dado que estoy en la página creación de categoría
        Cuando relleno lo siguiente:
        | Nombre      | Comercio Justo        |
        | Descripción | Descripción           |
        Y selecciono "Categoría A" de "Padre"
        Y marco "Habilitada"
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página esquema de categoría
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Comercio Justo"

    Escenario: Acceder al formulario de edición de categoría desde el listado
        Dado que estoy en la página principal de categoría
        Cuando presiono "Editar" junto a "Categoría B"
        Entonces debería estar en la página edición de categoría con nombre "Categoría B"

    Escenario: Actualizar categoría
        Dado que estoy en la página edición de categoría con nombre "Categoría A"
        Cuando relleno "Descripción" con "Categoría seleccionada A no disponible"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de categoría con nombre "Categoría A"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Descripción" debe contener "Categoría seleccionada A no disponible"

    Escenario: Borrar categoría desde la página de edición
        Dado que estoy en la página edición de categoría con nombre "Categoría A"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de categoría
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar categoría desde el listado
        Dado que estoy en la página principal de categoría
        Cuando presiono "Borrar" junto a "Categoría A"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de categoría
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Categoría A"

