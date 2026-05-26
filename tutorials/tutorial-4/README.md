# Aula Prática 04 – Web Services

**Instituto Superior de Engenharia de Lisboa**
Departamento de Engenharia Informática — LEIM
Sistemas Multimédia para a Internet – Semestre de Verão 2025/2026

> Docentes: Carlos Gonçalves, Jéssica Corujeira & Tiago Gonçalves

---

## Objetivo

Consolidar conhecimentos sobre **Web Services**, nomeadamente:

- Desenvolvimento de Web Services (SOAP e REST)
- Consumo de Web Services em **Java** e **PHP**

---

## Pré-requisitos (estudo prévio)

Antes de começar, estude os exemplos disponíveis no Moodle e no repositório:

| Exemplo                        | Caminho                                      | O que demonstra                                            |
| ------------------------------ | -------------------------------------------- | ---------------------------------------------------------- |
| `05-a-WS-SOAP-Generic`         | `examples-smi/05-a-WS-SOAP-Generic/`         | Cliente PHP genérico que liga a qualquer WSDL              |
| `05-b-WS-SOAP-NumberConverter` | `examples-smi/05-b-WS-SOAP-NumberConverter/` | Cliente PHP SOAP para o serviço NumberConversion           |
| `05-c-WS-REST-BookStoreClient` | `examples-smi/05-c-WS-REST-BookStoreClient/` | Cliente PHP REST para a API BookStore (cURL + AJAX)        |
| `06-Forms`                     | `examples-smi/06-Forms/`                     | Formulários com validação, AJAX, selects em cascata        |
| `12-OpenStreetMaps`            | `examples-smi/12-OpenStreetMaps/`            | Mapas interativos com Leaflet.js + GeoAPI.pt               |
| Java — SOAP                    | `Exemplos/Java/01-SOAP/`                     | Servidor JAX-WS + cliente CXF (proxy gerado do WSDL)       |
| Java — REST                    | `Exemplos/Java/02-REST/`                     | Servidor JAX-RS (Jersey/Grizzly) + cliente HttpClient/Gson |

---

## Tarefas

### Tarefa 1 — Cliente SOAP (PHP + Java)

**O que fazer:**
Escolher **um** Web Service SOAP da lista abaixo e desenvolver **dois clientes** que consumam esse serviço:

1. **Cliente PHP** — usando a classe `SoapClient` (ver exemplo `05-a` / `05-b`)
2. **Cliente Java** — usando JAX-WS ou CXF (ver exemplo `01-SOAP`)

**Web Services SOAP disponíveis para teste:**

| Serviço                                      | WSDL                                                                   |
| -------------------------------------------- | ---------------------------------------------------------------------- |
| TextCasing (upper/lower/inverter texto)      | https://www.dataaccess.com/webservicesserver/TextCasing.wso?WSDL       |
| NumberConversion (número → palavras/dólares) | https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL |
| Dilbert (strips do Dilbert)                  | http://www.gcomputer.net/webservices/dilbert.asmx?WSDL                 |
| Outros serviços gratuitos                    | http://free-web-services.com/                                          |

**Entregáveis:**

- `php-soap-client/` — cliente PHP funcional
- Módulo Java (ou classe `main`) — cliente Java funcional

---

### Tarefa 2 — Cliente REST BookStore (PHP + Java)

**O que fazer:**
Desenvolver **dois clientes** que consumam o serviço REST **BookStore** (servidor Java já fornecido):

1. **Cliente PHP** — usando cURL (ver exemplo `05-c`)
2. **Cliente Java** — usando `java.net.http.HttpClient` + Gson (ver exemplo `02-REST/Client`)

**Entregáveis:**

- `rest-bookstore-client/` — cliente PHP funcional (completar os stubs)
- Módulo/classe Java — cliente Java funcional

---

### Tarefa 3 — Web Service REST próprio (Java JAX-RS + cliente)

**O que fazer:**
Implementar um **Web Service REST em Java** usando anotações **JAX-RS** (Jersey + Grizzly, seguindo o padrão do exemplo `Server-JAX-RS`), e desenvolver um **cliente** (em qualquer linguagem).

**Operações obrigatórias:**

| Método HTTP | Endpoint (sugestão)     | Descrição                                                                       |
| ----------- | ----------------------- | ------------------------------------------------------------------------------- |
| `GET`       | `/api/datetime`         | `String getServerDateTime()` — Devolve a data e hora atual do servidor          |
| `GET`       | `/api/toupper?text=...` | `String toUpper(String)` — Devolve a string recebida convertida para maiúsculas |

**Requisitos do servidor:**

- Usar anotações JAX-RS: `@Path`, `@GET`, `@Produces`, `@QueryParam`
- Devolver respostas em JSON (e.g. `@Produces(MediaType.APPLICATION_JSON)`)
- Incluir filtro CORS (ver `CorsFilter.java` do exemplo)

**Requisitos do cliente:**

- Pode ser em Java (`HttpClient`), PHP (`cURL`), ou outra linguagem
- Deve chamar ambas as operações e mostrar os resultados

**Entregáveis:**

- Servidor JAX-RS funcional com as duas operações
- Cliente funcional que consome o serviço

---

### Tarefa 4 — Integração de OpenStreetMap no 06-Forms (PHP)

**O que fazer:**
Modificar o exemplo `06-Forms` para **substituir os mapas estáticos** (imagens do país e dos distritos) por um **mapa interativo OpenStreetMap** usando Leaflet.js.

**Comportamento esperado:**

- Ao selecionar um **distrito** no dropdown, o mapa deve atualizar-se e mostrar a **fronteira (polígono GeoJSON)** que delimita esse distrito
- _(Opcional)_ Ao selecionar um **concelho**, atualizar o mapa com a fronteira do concelho
- O mapa deve fazer `flyToBounds()` (ou `fitBounds()`) para enquadrar a área selecionada

**APIs a utilizar:**

| API                                    | Para quê                                          | Documentação                                     |
| -------------------------------------- | ------------------------------------------------- | ------------------------------------------------ |
| **Leaflet.js**                         | Renderizar o mapa interativo                      | https://leafletjs.com/reference.html             |
| **GeoAPI.pt**                          | Obter GeoJSON dos distritos/concelhos portugueses | https://geoapi.pt/docs/                          |
| **Leaflet.markercluster** _(opcional)_ | Agrupar marcadores no mapa                        | https://github.com/Leaflet/Leaflet.markercluster |

**Passos sugeridos:**

1. Adicionar Leaflet CSS + JS ao `formUpdateProfile.php` (ou página relevante)
2. Criar um `<div id="map">` onde estavam as imagens estáticas
3. Inicializar o mapa com `L.map()` centrado em Portugal (~lat 39.5, lng -8.0, zoom 7)
4. No evento `onchange` do select de distrito, fazer fetch a `https://geoapi.pt/distrito/{nome}?json=1` para obter o GeoJSON
5. Adicionar o GeoJSON ao mapa com `L.geoJSON()` e ajustar a vista com `flyToBounds()`
6. Remover a camada anterior ao trocar de distrito

**Referência:** Ver o exemplo `12-OpenStreetMaps/` que já demonstra todos estes padrões (incluindo `maps.js.php` com Leaflet + GeoAPI).

**Entregáveis:**

- `06-Forms/` modificado com mapa interativo em vez de imagens estáticas

---

## Resumo das entregas

| #   | Tarefa                          | Linguagens               | Baseado em                      |
| --- | ------------------------------- | ------------------------ | ------------------------------- |
| 1   | Cliente SOAP                    | PHP + Java               | `05-a`, `05-b`, `01-SOAP`       |
| 2   | Cliente REST BookStore          | PHP + Java               | `05-c`, `02-REST/Client`        |
| 3   | Servidor + Cliente REST próprio | Java (JAX-RS) + qualquer | `02-REST/Server-JAX-RS`         |
| 4   | OpenStreetMap no 06-Forms       | PHP + JavaScript         | `06-Forms`, `12-OpenStreetMaps` |

---

## Recursos SOAP adicionais

Para as tarefas 1 (e exploração extra), podem ser úteis:

- https://www.dataaccess.com/webservicesserver/TextCasing.wso
- https://www.dataaccess.com/webservicesserver/NumberConversion.wso
- http://www.gcomputer.net/webservices/dilbert.asmx
- http://free-web-services.com/
