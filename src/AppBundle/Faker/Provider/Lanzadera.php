<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 1/09/14
 * Time: 12:55
 */

namespace AppBundle\Faker\Provider;

use Faker\Provider\Base;

class Lanzadera extends Base
{
    protected static $collective = array(
        "Adismar",
        "Editorial Atrapasueños",
        "Transformando SCA",
        "La industria de Mayka",
        "Cervezas Artesanas Son",
        "Cooperativa El Humoso de Marinaleda",
        "Finca Ocupada Somonte",
        "La Vuelta al Mundo",
        "Agua de Coco",
        "COPADE",
        "Mosayco Mediterraneo",
        "Efecto Tortuga",
        "Mimarte",
    );

    protected static $product = array(
        "Sal",
        "Ajo en polvo",
        "Cebolla en polvo",
        "Tomillo",
        "Salvia, Mejorana",
        "Orégano",
        "Pimienta",
        "Curry",
        "Laurel en Hojas",
        "Comino",
        "Color Onoto",
        "Colorante paella",
        "Cubitos pollo",
        "Cubitos carne",
        "Cubitos pescado",
        "Cubitos tocineta",
        "Maiz dorado",
        "Consomé",
        "Vegetales mixtos",
        "Petit poies",
        "Caraotas negras",
        "Tomates naturales",
        "Jamón Endiablado",
        "Atún",
        "Sardinas",
        "Anchoas",
        "Cocktail frutas",
        "Leche en polvo",
        "Leche condensada",
        "Concentrados de fruta",
        "Mantequilla en lata",
        "Pasapalos en lata",
        "Lentejas",
        "Arbejitas verdes",
        "Garbanzos",
        "Caraotas rojas",
        "Caraotas blancas",
        "Caraotas negras",
        "Quinchonchos",
        "Frijoles",
        "Arbejitas congeladas (bolsa)",
        "Azúcar",
        "Azúcar morena",
        "Azúcar pulverizada",
        "Polvo de hornear",
        "Levadura",
        "Nuez Moscada",
        "Canela (en polvo y en rama)",
        "Cremor tártaro",
        "Guayabita",
        "Fécula de maíz",
        "Confites adorno",
        "Vainilla",
        "Colorantes artificiales",
        "Frutas glaseadas",
        "Pasas, guindas",
        "Gelatinas",
        "Chocolate polvo",
        "Sirop (fresa, mora, chocolate)",
        "Galletas",
        "Cereales",
        "Helado",
        "Yogurt firme",
        "Puré de papas",
        "Harina de Trigo",
        "Harina de Maíz",
        "Afrecho",
        "Pan rallado",
        "Avena hojuela",
        "Arroz",
        "Pasta al huevo",
        "Pasta de sémola",
        "Huevos",
        "Panquecas",
        "Harina de avena",
        "Aceite",
        "Vinagre",
        "Vino cocinar",
        "Salsa inglesa",
        "Salsa Soya",
        "Salsa de Tomate",
        "Pasta tomate concentrada",
        "Mayonesa",
        "Mostaza",
        "Pastas para untar",
        "Alcaparras",
        "Aceitunas",
        "Jabón de lavar",
        "Blanqueador",
        "Limpiador de pocetas",
        "Detergente líq./polvo",
        "Cloro",
        "Limpiador de muebles",
        "Jabón lavaplatos",
        "Pañitos secar",
        "Esponjitas",
        "Cepillos lavar",
        "Servilletas",
        "Toallin absorbente",
        "Papel encerado",
        "Papel aluminio",
        "Papel plástico envolvente",
        "Jabón tocador",
        "Champú él/ella",
        "Enjuague",
        "Desodorontes",
        "Toallas sanit.",
        "Papel higiénico",
        "Hojillas afeitar",
        "Espuma afeitar",
        "Pasta dental",
        "Removedor de esmalte",
    );

    protected static $categories = array(
        "Productos Químicos",
        "Pinturas",
        "Aceites",
        "Herramientas",
        "Instrumentos musicales",
        "Muebles",
        "Tejidos",
        "Alfombras",
        "Alimentación",
        "Cervezas",
        "Vinos",
        "Ropa",
        "Cuadros",
    );

    protected static $tags = array(
        "abril",
        "actividad",
        "actual",
        "alimentaria",
        "alternativas",
        "aves",
        "bandolera",
        "calle",
        "cambio",
        "categorías",
        "climático",
        "comentario",
        "comparte",
        "concierto",
        "economía",
        "emergencia",
        "entradas",
        "guadalquivir",
        "incongruencia",
        "izquierda",
        "junio",
        "libro",
        "mercao",
        "mesa",
        "noticias",
        "palestina",
        "portugal",
        "proyectos",
        "pueblo",
        "punto",
        "córdoba",
        "realidad",
        "situación",
        "soberanía",
        "social",
        "tejedora",
    );

    public static function collective()
    {
        return static::randomElement(static::$collective);
    }

    public static function product()
    {
        return static::randomElement(static::$product);
    }

    public static function category()
    {
        return static::randomElement(static::$categories);
    }

    public static function allCategories()
    {
        return static::$categories;
    }

    public static function tag()
    {
        return static::randomElement(static::$tags);
    }

    public static function allTags()
    {
        return static::$tags;
    }
} 