# Execucao do Projeto

## Requisitos

- Docker
- Docker Compose

## Arranque rapido

Na raiz do projeto, executar:

```bash
docker compose up -d
```

Depois abrir:

- `http://localhost:8080`

## Primeiro arranque

No primeiro acesso, a aplicacao redireciona automaticamente para o assistente de configuracao inicial.

E necessario:

1. Confirmar a configuracao da base de dados
2. Concluir a inicializacao do esquema da base de dados
3. Criar o primeiro utilizador administrador

## Notas

- A pasta `vendor/` esta incluida, por isso nao e necessario executar `composer install`
- A base de dados e arrancada pelo `docker compose`, por isso nao e necessario instalar MySQL separadamente
- Se a porta `8080` estiver ocupada, ajustar `APP_PORT` antes de arrancar os contentores

## Reposicao do ambiente

Se for necessario recriar a base de dados de raiz:

```bash
docker compose down -v
docker compose up -d
```
