#language: es
@products
Característica: productos
    Para llevar una gestión de los productos
    Como administrador del mercao social
    Quiero poder gestionar un catálago de productos

    Antecedentes:
        Dado que existen los siguientes usuarios:
            | username  | password  | email                 | enabled | role        |
            | admin     | adminpw   | admin@latejedora.com  | 1       | ROLE_ADMIN  |
        Y que estoy autenticado como administrador
        Y existen las siguientes organizaciones:
            | name            | enabled |
            | Organización A  | 1       |
            | Organización B  | 1       |
            | Organización C  | 1       |
            | Organización D  | 1       |
        Y existen los siguientes productos:
            | nombre          | descripción           | organización    |
            | Producto A1     | Características de A1 | Organización A  |
            | Producto A2     | Características de A2 | Organización A  |
            | Producto B1     | Características de B1 | Organización B  |
            | Producto B2     | Características de B2 | Organización B  |
            | Producto B3     | Características de B3 | Organización B  |
            | Producto C1     | Características de C1 | Organización C  |

    Escenario: Ver el listado de productos
        Dado que estoy en la página del escritorio
        Cuando presiono listar las productos
        Entonces debería estar en la página principal de producto
        Y debería ver 6 productos en la lista

    Escenario: Buscar productos
        Dado que estoy en la página principal de producto
        Cuando relleno "Nombre" con "Producto B1"
        Y presiono "Filtrar"
        Entonces debería estar en la página principal de producto
        Y debería ver 1 producto en la lista

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
        Y presiono "Crear y regresar al listado"
        Entonces debería estar en la página principal de producto
        Y debo ver "Elemento creado satisfactoriamente"
        Y debo ver "Café Torrefacto"

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
