<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Тестовое задание</h1>
    <br>
</p>

[Тестовое задание](https://docs.google.com/document/d/1Z9bqXLtG1Zjr9RaC-SQpBOC3Kn1BVsRerP_kieamXLM) для компании Prosto.Insure
Использовался базовый шаблон приложения Yii2

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      components/         contains App components
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------
PHP 7.1.0.

DEPLOYING
------------
1. Необходимо установить настройки подключения к бд в /config/db.php
2. Через консоль запустить миграции ```php yii migrate```
3. Через консоль запустить импорт курса валют ```php yii currency/update ``` 
4. При тестировании REST API необходимо указать токен ```xx508xx63817x752xx74004x30705xx92x58349x5x78f5xx34xxxxx51``` 
При желании токен можно поменять в /models/User.php для пользователя admin
