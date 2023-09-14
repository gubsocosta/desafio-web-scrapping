# Desafio Web-Scraping

## Descrição
Esta aplicação tem como o objetivo apresentar informações de moedas, usando a técnica de *web-scraping*.

## Dependências
- docker 25.0.5
- php 8.2
- composer 2.6.2
- laravel 10.x

## Iniciando a aplicação
Crie o arquivo `.env`

```shell
$ cp .env.example .env
```

Instale as dependências via docker:

```shell
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Suba os containers:

```shell
$ ./vendor/bin/sail up --force-recreate -d
```

Gere o `app_key` com o comando:

```shell
$ ./vendor/bin/sail artisan key:generate
```

Execute a aplicação:

```shell
$ ./vendor/bin/sail artisan serve
```
A aplicação estará sendo executada na porta 8000.

Para acessar a rota principal, faça a requisição, como o exemplo abaixo:

```shell
$ curl --request GET \
  --url 'http://localhost:8000/api/currency-info?isoCodes%5B%5D=USD&isoCodes%5B%5D=BRL'
```

O endpoint espera que seja enviado uma lista de códigos no formato [ISO-4217](https://www.iso.org/iso-4217-currency-codes.html). E retorna como resposta uma lista, contendo informações sobre as moedas relacionadas a cada código.

```json
{
    "isoCode": "BRL",
    "numericCode": 986,
    "decimalPlaces": 2,
    "name": "Real",
    "locationList": [
        {
            "location": "Brasil",
            "flagIconUrl": "https://example.com/brazil-icon.png"
        }
    ]
}
```

Caso queira parar a aplicação, execute o comando abaixo:


```shell
$ ./vendor/bin/sail artisan stop
```


Para ver a executar dos testes de unidade, execute o comando abaixo:

```shell
$ ./vendor/bin/sail test
```

Para remover os containers:
```shell
$ ./vendor/bin/sail down --remove-orphans
```

## Comentários do desenvolvedor
Para a realização desse desafio, optei por usar `php` com o framework `laravel` por ter um domínio sobre essas tecnologias e por conta da documentacao acessível.

Procurei aplicar as boas práticas de desenvolvimento (SOLID, clean code, design patterns, TDD) usando uma versão adaptada de clean architecture e DDD.

Infelizmente, nao foi possível cumprir todos requisitos pedidos para a conclusão deste desafio.

Tive dificuldades e criar uma rotina para poder capturar as informações dos países que utilizam determinada moeda. Fiz várias tentativas, usando a biblioteca [*DOMCrawler*](https://symfony.com/doc/current/components/dom_crawler.html#expression-evaluation), porém sem sucesso.

Com tudo, acredito que o que foi realizado mostra bem os meus conhecimentos adquiridos ao longo de toda a minha jornada como desenvolvedor.

Aqui eu deixo um check-list do que pode ser melhorado nesse desafio:

- migrar para um micro-framework (lumen, symphony). A utilização de um framework full-stack acaba trazendo recursos que não serão utilizados 
- realizar a implementação do `CacheClient` em memória, para facilitar os testes de integração
- testes de integração do endpoint, para poder garantir a integridade do mesmo
- um caso de uso para poder realizar a busca das informações da moeda pelo codigo numérico (não foi realizado devido ao problema mencionada acima)
- testes de mutação, para poder avaliar melhor a qualidade dos testes criados.
