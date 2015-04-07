<?php

namespace AppBundle\Admin;

use Sonata\ClassificationBundle\Admin\CategoryAdmin as BaseCategoryAdmin;

class CategoryAdmin extends BaseCategoryAdmin
{
    protected $baseRouteName = "lanzadera_category";
}
