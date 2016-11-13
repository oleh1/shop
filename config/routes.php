<?php

return array(
    'product/([0-9]+)' => 'product/view/$1', // views/product/view.php

    'catalog' => 'catalog/index', // views/catalog/index.php

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // views/catalog/category.php
    'category/([0-9]+)' => 'catalog/category/$1', // views/catalog/category.php

    'user/register' => 'user/register', // views/user   /register.php
    'user/login' => 'user/login', // views/user   /register.php

    'cabinet' => 'cabinet/index', // views/cabinet/index.php

    '' => 'site/index', // views/site/index.php
);