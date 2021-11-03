
# TransferWay

Um novo jeito de transferir dinheiro entre pessoas e lojistas. Crie sua conta hoje mesmo a partir de uma API incrível e escalável =).
A API consiste em uma carteira virtual que pode ser utilizada para transferência de fundos entre usuários, para começar a utilizar a API, basta cadastrar-se através dos endpoints de usuário e logo em seguida depositar valores na sua carteira.


## Rodar o projeto localmente

Clone o projeto

```bash
  git clone https://github.com/victorfarias98/transferway
```

Vá até o diretório do projeto

```bash
  cd my-project
```

#### Crie um arquivo .env a partir do arquivo .env.example

Instale o projeto com composer

```bash
  composer install
```

Rode as migrations

```bash
  php artisan migrate
```

Start the server

```bash
  php artisan serve
```




## Exemplos de retornos e requests da API


#### GET /user
```json
# Recupera Lista de usuários
{
    "users" : {
        {
            "name": "Victor Farias",
            "email": "vgfr456@gmail.com"
            "password": "%$%$%$%%$%$%$%$%$$%$"
        },
        {},
        {}
    }
}
```
#### POST /user
```json
# Cadastra um novo usuário
{
    "name" : "Victor Farias =)",
    "email": "vgfr456@gmail.com",
    "document": "111111111111111",
    "type": "PF",
    "password": "123456789"
}
```
#### PUT /user
```json
# Atualiza um usuário
{
    "user_id" : "1",
    "name" : "Victor Farias",
    "email": "vgfr123@gmail.com",
}
```
#### DELETE /user
```json
# Deleta um usuário
{
    "user_id" : "1",
}
```
## Wallet API 

#### POST /user/wallet/deposit
```json
# Cria-se automáticamente uma carteira para o usuário com id 1 caso não exista
{
    "user_id" : 1,
    "amount": 10
}
```
#### GET /user/wallet/balance
```json
# Recupera o saldo do usuário
{
    "user_id" : 1,
    //"Balance": 10
}
```

#### POST /user/wallet/transer
```json
# Realiza a transferência entre usuários (Apenas Pessoas físicas podem transferir)
{
    "payer_id" : 1,
    "payee_id" : 2,
    "amount": 5
}
```
## Tecnologias utilizadas

 - [Laravel](https://laravel.com/)
 - [Laravel Wallet](https://bavix.github.io/laravel-wallet/)


## Roadmap do TransferWay

- Utilizar Repositories para regras de negócio
- Utilizar middlewares de autenticação nas rotas de carteira e de usuários
- Trocar o id por UUID
- Utilizar JWT auth nas rotas de API
- Criar serviço de confirmação de e-mail
- Hospedar o projeto na digital ocean
- Criar um JOB para o serviço de e-mail
- Arquitetar um container docker para o projeto
- Aplicação de testes unitários a partir do PHP Unit

