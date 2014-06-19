#language: es
@organizations
Característica: Organizaciones
    Para llevar una gestión de las organizaciones
    Como administrador del mercao social
    Quiero poder administrar las entidades que venden en nuestra organización

    Antecedentes:
      Dado que estoy autenticado como administrador
        Y existen las siguientes organizaciones:
          | nombre         |
          | Organización A |
          | Organización B |
          | Organización C |
          | Organización D |

    Escenario: Ver el listado de organizaciones
        Dado que estoy en el panel de administración
        Cuando entro en la sección de organizaciones
        Entonces debo estar en la página de administración de organizaciones
        Y debería ver 4 elementos en la lista

    Escenario: Nombres en el listado de organizaciones
        Dado que estoy en el panel de administración
        Cuando entro en la sección de organizaciones
        Entonces debo estar en la página de administración de organizaciones
        Y debería ver la organización "Organización D"

    Escenario: Ver un listado vacío de organizaciones
        Dado que no hay organizaciones registradas
        Cuando estoy en la página de administración de organizaciones
        Entonces debería ver "No hay resultados"

    Escenario: Acceder al formulario de creación de organizaciones
        Dado que estoy en el panel de administración
        Cuando entro en la sección de organizaciones
        Y presiono sobre "Agregar nueva"
        Entonces debo estar en la página de creación de organizaciones

    Escenario: Rellenar un formulario incompleto
        Dado que estoy en la página de creación de organizaciones
        Cuando presiono sobre "Crear"
        Entonces aún debo estar en la página de creación de organizaciones
        Y debería ver "Por favor, introduzca un nombre."

#TODO: Escenarios de campos requeridos

#TODO: Escenario de crear empresa completa

    Escenario: Las nuevas organizaciones aparecen en el listado
        Dado que he creado la organización "Organización E"
        Cuando entro en la página de administración de organizaciones
        Entonces debería ver 5 elementos en la lista
        Y debería ver la organización "Organización E"

    Escenario: Acceder al formulario de edición de organización
        Dado que esto en la página de la organización "Organización A"
        Cuando presiono "Editar"
        Entonces debo estar en la página de edición de la organización "Organización A"

    Escenario: Acceder al formulario de edición desde el listado
        Dado que estoy en la página de administración de organizaciones
        Cuando presiono "Editar" de la "Organización A"
        Entonces debo estar en la página de edición de la organización "Organización A"

#TODO: Escenario de actualización

    Escenario: Borrar organización
        Dado que estoy en la página de edición de la organización "Organización A"
        Cuando presiono "Borrar"
        Y presiono "Sí, borrar" en la página de confirmación
        Entonces debo estar en la página de administración de organizaciones
        Y debo ver "Elemento eliminado satisfactoriamente."

    Escenario: Borrar organización desde el índice
        Dado que estoy en la página de administración de organizaciones
        Cuando presiono "Borrar" de la "Organización A"
        Y presiono "Sí, borrar" en la página de confirmación
        Entonces aún debo estar en la página de administración de organizaciones
        Y debo ver "Elemento eliminado satisfactoriamente."
        Y no debería ver la organización "Organización A" en el listado

