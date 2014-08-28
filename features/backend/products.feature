#language: es
@products
Característica: productos
    Para llevar una gestión de los productos
    Como administrador del mercao social
    Quiero poder gestionar un catálago de productos

    Antecedentes:
        Dado que estoy autenticado como administrador
        Y existen las siguientes organizaciones:
            | name            | enabled |
            | Organización A  | 1       |
            | Organización B  | 1       |
            | Organización C  | 1       |
            | Organización D  | 1       |
        Y existen las siguientes taxonomías:
            | nombre          | id          |
            | Categoría       | Category    |
            | Tag             | Tag         |
        Y la taxonomía "Category" tiene los siguientes elementos:
            | Categoría A > Categoría A.1 > Categoría A.1.1 |
            | Categoría B > Categoría B.1                   |
            | Categoría C > Categoría C.1                   |
        Y la taxonomía "Tag" tiene los siguientes elementos:
            | Etiqueta A      |
            | Etiqueta B      |
            | Etiqueta C      |
            | Etiqueta D      |
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
        Y existen los siguientes productos:
            | nombre          | organización    | categoría     | etiquetas               |
            | Producto A1     | Organización A  | Categoría A   | Etiqueta A, Etiqueta B  |
            | Producto A2     | Organización A  | Categoría B   | Etiqueta B, Etiqueta C  |
            | Producto B1     | Organización B  | Categoría A.1 | Etiqueta C, Etiqueta D  |
            | Producto B2     | Organización B  | Categoría A.1 | Etiqueta D, Etiqueta A  |
            | Producto B3     | Organización B  | Categoría B   | Etiqueta A, Etiqueta C  |
            | Producto C1     | Organización C  | Categoría C   | Etiqueta B, Etiqueta D  |
        Y el producto "Producto A1" tiene los siguientes indicadores:
            | criterio              | indicador |
            | Producción ecológica  | Alto      |
            | Origen del producto   | Andalucía |

    Escenario: Ver el listado de productos
        Dado que estoy en la página del escritorio
        Cuando presiono listar las productos
        Entonces debería estar en la página principal de producto
        Y debería ver 6 productos en la lista

    Escenario: Buscar productos por nombre
        Dado que estoy en la página principal de producto
        Cuando relleno "Nombre" con "Producto B1"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de producto
        Y debería ver 1 producto en la lista

    Escenario: Buscar productos por categoría
        Dado que estoy en la página principal de producto
        Cuando selecciono "Categoría B" de "Categoría"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de producto
        Y debería ver 2 productos en la lista

    Escenario: Buscar productos por etiqueta
        Dado que estoy en la página principal de producto
        Cuando selecciono "Etiqueta B" de "Etiquetas"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de producto
        Y debería ver 3 productos en la lista

    Escenario: Acceder a los detalles del producto desde el listado
        Dado que estoy en la página principal de producto
        Cuando presiono "Mostrar" junto a "Producto C1"
        Entonces debería estar en la página de producto con nombre "Producto C1"

    Escenario: Acceder al formulario de creación de productos
        Dado que estoy en la página principal de producto
        Y sigo "Agregar nuevo"
        Entonces debería estar en la página creación de producto

    Escenario: Enviar formulario vacío
        Dado que estoy en la página creación de producto
        Cuando presiono "Crear y editar"
        Entonces debería estar todavía en la página creación de producto
        Y debo ver "Por favor, indique el nombre del producto."

    Escenario: Crear producto
        Dado que estoy en la página creación de producto
        Cuando relleno lo siguiente:
            | Nombre      | Café Torrefacto       |
            | Descripción | Café 100% natural     |
        Y selecciono "Organización D" de "Organización"
        Y selecciono "Categoría B" de "Categoría"
        Y selecciono "Etiqueta A" de "Etiquetas"
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de producto
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Café Torrefacto"
        Y debo ver "Etiqueta A"

    Escenario: Acceder al formulario de edición de producto desde el listado
        Dado que estoy en la página principal de producto
        Cuando presiono "Editar" junto a "Producto B1"
        Entonces debería estar en la página edición de producto con nombre "Producto B1"

    Escenario: Actualizar producto
        Dado que estoy en la página edición de producto con nombre "Producto A1"
        Cuando relleno "Descripción" con "Nuevo y mejorado producto A1"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de producto con nombre "Producto A1"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y el campo "Descripción" debe contener "Nuevo y mejorado producto A1"

    @javascript
    Escenario: Agregar una nueva etiqueta a un producto
        Dado que estoy en la página edición de producto con nombre "Producto A1"
        Y sigo "Añadir etiqueta"
        Y espero que se abra la ventana
        Y relleno "Nombre de etiqueta" con "Etiqueta G"
        Y presiono "Crear"
        Y espero que se cierre la ventana
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de producto con nombre "Producto A1"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y debo ver "Etiqueta G"

    Escenario: Seleccionar un indicador
        Dado que estoy en la página edición de producto con nombre "Producto A2"
        Y selecciono el indicador "Muy alto" del criterio "Producción ecológica"
        Y presiono "Actualizar"
        Entonces debería estar en la página edición de producto con nombre "Producto A2"
        Y debo ver "Elemento actualizado satisfactoriamente."
        Y debo ver el indicador "Muy alto" en el criterio "Producción ecológica"

    Escenario: Borrar producto desde la página de edición
        Dado que estoy en la página edición de producto con nombre "Producto A1"
        Cuando sigo "Borrar"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de producto
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Producto A1"

    Escenario: Borrar producto desde el listado
        Dado que estoy en la página principal de producto
        Cuando presiono "Borrar" junto a "Producto A1"
        Entonces debo ver "¿Está seguro de que quiere borrar el elemento seleccionado?"
        Cuando presiono "Sí, borrar"
        Entonces debería estar en la página principal de producto
        Y debo ver "Elemento eliminado satisfactoriamente."
        Pero no debo ver "Producto A1"
