## Requisitos

* PHP 8.2 ou superior
* MySQL 8 ou superior
* Composer

## Como rodar o projeto

Duplicar o arquivo ".env.exaple" e renomear para .env.<br>
Alterar no arquivo .env as credenciais do banco de dados<br>

Instalar as dependências do PHP
```
composer install
```

Gerar a chave no arquivo .env
```
php artisan key:generate
```

Executar as Migrations
```
php artisan migrate
```

Executar as seeds
```
php artisan db:seed
```

## Sequencia para criar o projeto
Criar o projeto com laravel:
```
Composer create-project laravel/laravel .
```

Criar o arquivo de rotas para API
```
php artisan install:api
```

Iniciar o servidor
```
php artisan serve
```

Criar seed
```
php artisan make:seeder NomeDaSeeder
php artisan make:seeder UserSeeder
```

Executar as seeds
```
php artisan db:seed
```
