<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 1/09/14
 * Time: 12:55
 */

namespace Lanzadera\FixtureBundle\Faker\Provider;


class Lanzadera extends \Faker\Provider\Base
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
        "Tomates",
        "Calabacines",
        "Lechugas",
        "Pepinos",
        "Pimientos",
        "Habas",
        "Guisantes",
        "Bróculi",
        "Coliflor",
        "Col",
        "Lombardas",
        "Remolacha",
        "Zanahorias",
        "Acelgas",
        "Patatas",
        "Judías Verdes",
        "Berenjenas",
        "Alcachofas",
        "Rábano",
        "Hinojo",
        "Rabanito",
        "Repollo",
        "Calabazas",
        "Apio"  
    );

    protected static $category = array(
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
        return static::randomElement(static::$category);
    }
} 