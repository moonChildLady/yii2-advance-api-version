<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project [supermarket]</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

REST API URL
-------------------

Get category [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/category
```
Get product category [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/products/get-category/{id}
```

Get products [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/products
```

Get products details [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/products/get-product/{id}
```

Signup [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/user/signup
```

Login [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/user/login
```

Get user detail [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/user/get-user
```

Get shopping carts [GET]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/carts
```

Add product to shopping cart [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/carts/add-to-cart
```

Delete shopping cart product [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/carts/delete-product
```

Delete all shopping cart product [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/carts/delete-all
```

Add quantity on the shopping cart [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/carts/add-quantity
```

Get all comments of the product [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/products/get-comments/{id}
```

Add comment [POST]
```
https://demo.hikinginspire.com/proj/supermarket/api/v1/products/add-comments/{id}
```


DIRECTORY STRUCTURE
-------------------

```
api
    config/              contains api configurations
    web/                 contains the entry script and Web resources (upload folder)
    runtime/             contains files generated during runtime
    modules/             contains the version of the API
        v1/
            controllers/         contains API controller classes and action

common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
