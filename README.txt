Clonar projeto - git clone https://github.com/juliojpj/bolton-api.git
Laravel > 5.5
PHP > 7
MySql


-- INSTALAÇÂO 
Na pasta do projeto, instalar os modulos com o comando >composer install
No arquivo config/database.php e .env, apontar para o banco MySql e um Schema. 


Executar os comandos:
>php artisan migrate
>php artisan serve


-- UTILIZAÇÂO
// Cadastrar na API a primeira vez para gerar o token. Expira em 1 hora
POST - server:porta/api/register
        Header:        key:                value:
                        name                nome-usuario
                        email                email-usuario
                        password        senha-usuario


Response: bearer token para acessar a api




// Logar na API caso precise gerar um novo token
POST - server:porta/api/login
        Header:        key:                value:
                        email                email-usuario
                        password        senha-usuario
                        
Response: bearer token para acessar a api




// Importar as notas da API da Arquivei
GET - server:porta/api/import
        Authorization:
                Type: Bearer token                Token: gerado no endpoint /api/register ou /api/login
                        
Response: JSON informando o status da importação.




// Buscar valor da nota pela chave de acesso
GET - server:porta/api/notas/{chave_de_acesso}
        Header:        key:                value:
                        Accept                application/json
        Authorization:
                Type: Bearer token                Token: gerado no endpoint /api/register ou /api/login
                        
Response: JSON com Chave de Acesso e o valor da nota.