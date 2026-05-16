# Análise do Problema

O projeto **Rooted** consiste no desenvolvimento de um Sistema de Gestão de Conteúdos (SGC) orientado à partilha de conteúdos multimédia no domínio da jardinagem e botânica. A aplicação permite que utilizadores partilhem fotografias, vídeos e áudio relacionados com plantas, jardins e técnicas de cultivo, cada um acompanhado de descrições textuais e meta-informação relevante.

O sistema é acedido exclusivamente através de um browser e suporta quatro perfis de utilização com níveis de permissão progressivos: **Convidado**, **Utilizador**, **Moderador** e **Administrador**. O perfil **Moderador** corresponde ao perfil _Simpatizante_ descrito no enunciado do trabalho; a designação foi alterada por refletir com maior precisão o papel deste perfil no contexto da aplicação, uma vez que, para além de criar conteúdos próprios, o moderador assume também responsabilidades de melhorar os conteúdos de outros utilizadores (ver justificação em M14/M15).

Os conteúdos são organizados por **etiquetas**, divididas em duas categorias: **etiquetas principais**, definidas exclusivamente pelos administradores (ex. "Flores", "Hortícolas", "Suculentas"), e **etiquetas secundárias**, criadas pelos moderadores (ex. "Rega Gota-a-Gota", "Cultivo Interior"). Adicionalmente, os moderadores podem associar **meta-informação** livre a cada conteúdo (tipo de solo, exposição solar, frequência de rega, entre outros).

Cada conteúdo possui um nível de **visibilidade** que determina quem pode aceder ao mesmo. No enunciado do trabalho esta propriedade é referida como _pública_ ou _privada_; na implementação, optámos pela terminologia **`public`** e **`internal`**. A distinção é intencional: um conteúdo marcado como `internal` não é privado no sentido estrito (visível apenas ao autor), mas sim **visível a qualquer utilizador autenticado** da plataforma. A designação `internal` traduz com maior clareza esta semântica de acesso restrito à comunidade registada.

## Funcionalidades do Sistema

O sistema foi desenhado em torno de quatro perfis de utilização com permissões progressivas. Cada perfil aplica todas as funcionalidades do anterior. Além disso, a aplicação oferece um conjunto de funcionalidades transversais que não estão associadas a um perfil específico.

### Convidado

O Convidado é o perfil mais restritivo. Não requer autenticação e destina-se a visitantes que pretendem explorar os conteúdos públicos disponíveis na plataforma.

| #   | Funcionalidade              | Descrição                                                                                                                                |
| --- | --------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| C1  | Pesquisar plantas           | Pesquisa de plantas através de texto livre, com resultados baseados em nomes, descrições e meta-informação associada aos conteúdos       |
| C2  | Filtrar por etiqueta        | Navegação e filtragem dos conteúdos públicos com base nas etiquetas associadas                                                           |
| C3  | Filtrar por meta-informação | Filtragem dos conteúdos com base em meta-informação associada (ex. tipo de solo, exposição solar)                                        |
| C4  | Ver conteúdo público        | Visualização da página de detalhe de uma planta, incluindo os seus conteúdos multimédia (fotografias, vídeos, áudio) e descrição textual |
| C5  | Registar conta              | Criação de uma nova conta de utilizador através de um formulário de registo                                                              |

### Utilizador

O Utilizador é um visitante autenticado. Para além de explorar conteúdos, pode personalizar a sua experiência através de subscrições a etiquetas de interesse, sendo notificado quando surgem novos conteúdos relevantes.

| #   | Funcionalidade                 | Descrição                                                                                                                                |
| --- | ------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------- |
| U1  | Autenticar                     | Iniciar e terminar sessão na aplicação através de credenciais (email e password)                                                         |
| U2  | Subscrever notificações        | Subscrição a etiquetas de interesse; quando novos conteúdos são adicionados com essas etiquetas, o utilizador é notificado               |
| U3  | Receber notificações por email | Receção de emails automáticos sempre que são adicionados conteúdos que correspondam às etiquetas subscritas                              |
| U4  | Gerir subscrições              | Visualização, adição e remoção das etiquetas subscritas                                                                                  |
| U5  | Gerir perfil                   | Edição dos dados pessoais (nome, email, password) e preferências de notificação (ex. frequência de emails, etiquetas de interesse)       |
| U6  | Ver conteúdo interno           | Visualização da página de detalhe de uma planta, incluindo os seus conteúdos multimédia (fotografias, vídeos, áudio) e descrição textual |

### Moderador

O Moderador (equivalente ao perfil _Simpatizante_ descrito no enunciado) é o principal criador de conteúdos da plataforma. Pode adicionar, editar e gerir plantas e respetivos conteúdos multimédia, criar etiquetas secundárias, associar meta-informação e definir a visibilidade dos seus conteúdos.

| #   | Funcionalidade              | Descrição                                                                                                                                              |
| --- | --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| M1  | Adicionar planta            | Criação de uma nova entrada de planta no sistema, com nome, descrição textual e conteúdos multimédia (fotografia, vídeo ou áudio)                      |
| M2  | Editar planta               | Modificação dos dados de uma planta existente, incluindo a sua descrição e conteúdos multimédia                                                        |
| M3  | Apagar planta               | Remoção de uma planta e todos os conteúdos associados do sistema                                                                                       |
| M4  | Definir visibilidade        | Associação de visibilidade **pública** ou **interno** a cada conteúdo                                                                                  |
| M5  | Criar etiquetas secundárias | Criação de novas etiquetas secundárias para organizar os conteúdos do sistema                                                                          |
| M6  | Editar etiqueta secundária  | Modificação do nome ou descrição de uma etiqueta secundária existente, criada pelo próprio moderador                                                   |
| M7  | Apagar etiqueta secundária  | Remoção de uma etiqueta secundária do sistema e desassociação dos conteúdos correspondentes                                                            |
| M8  | Atribuir etiquetas          | Associação de etiquetas aos conteúdos enviados para o sistema                                                                                          |
| M9  | Adicionar meta-informação   | Associação de informação descritiva livre aos conteúdos (ex. "Solo: argiloso", "Rega: semanal", "Zona climática: temperada")                           |
| M10 | Upload unitário             | Envio de um único conteúdo multimédia com a respetiva meta-informação através de formulário                                                            |
| M11 | Upload em lote (ZIP)        | Envio de múltiplos conteúdos agrupados num ficheiro `.zip`, acompanhados de um ficheiro `metadata.xml` que descreve a meta-informação de cada conteúdo |
| M12 | Download unitário           | Obtenção de um conteúdo multimédia individual do sistema                                                                                               |
| M13 | Download em lote (ZIP)      | Obtenção de múltiplos conteúdos agrupados num ficheiro `.zip`, incluindo um ficheiro `metadata.xml` com a meta-informação correspondente               |
| M14 | Editar conteúdo global      | Modificação de qualquer conteúdo no sistema, independentemente do autor                                                                                |
| M15 | Apagar conteúdo global      | Remoção de qualquer conteúdo no sistema, independentemente do autor                                                                                    |

> **Nota sobre M14/M15 — Edição e remoção global de conteúdos:** O enunciado atribui ao Simpatizante a capacidade de _"gerir os seus conteúdos (apagar, modificar, etc.)"_. Na aplicação Rooted, optámos por alargar este âmbito ao permitir que o Moderador edite e remova qualquer conteúdo, independentemente do autor. Esta decisão decorre do papel de melhoria que o Moderador assume na plataforma: sendo o perfil responsável pela qualidade e organização dos conteúdos, é expectável que possa corrigir ou remover conteúdos inadequados sem depender da intervenção de um Administrador. A designação _Moderador_ reflete precisamente esta responsabilidade adicional face ao perfil _Simpatizante_ original.

### Administrador

O Administrador possui privilégios totais sobre o sistema. Para além de todas as funcionalidades anteriores, é responsável pela gestão de utilizadores, configurações globais da aplicação e pela definição das etiquetas principais que estruturam a organização dos conteúdos.

| #   | Funcionalidade              | Descrição                                                                                                 |
| --- | --------------------------- | --------------------------------------------------------------------------------------------------------- |
| A1  | Adicionar utilizador        | Criação de uma nova conta de utilizador com atribuição de perfil (Utilizador, Moderador ou Administrador) |
| A2  | Ver utilizador              | Visualização dos dados de qualquer conta de utilizador registada no sistema                               |
| A3  | Editar utilizador           | Modificação dos dados de uma conta de utilizador, incluindo a alteração do perfil atribuído               |
| A4  | Apagar utilizador           | Remoção de uma conta de utilizador e respetivos dados associados do sistema                               |
| A5  | Configurar base de dados    | Definição dos parâmetros de acesso à base de dados (host, porta, nome da base de dados, credenciais)      |
| A6  | Configurar serviço de email | Configuração do servidor SMTP e credenciais utilizados para o envio de notificações por email             |
| A7  | Gerir etiquetas principais  | Criação, edição e remoção de etiquetas principais para a organização global dos conteúdos do sistema      |

### Funcionalidades Gerais da Aplicação

Para além das funcionalidades associadas a cada perfil, o sistema inclui um conjunto de funcionalidades transversais.

| #   | Funcionalidade                      | Descrição                                                                                                                                                                                                           |
| --- | ----------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| G1  | Autenticação por password           | Autenticação convencional através de email e password                                                                                                                                                               |
| G2  | Autenticação por token (2FA)        | Autenticação em dois fatores: é enviado um token por email que o utilizador deve introduzir para confirmar a sessão                                                                                                 |
| G3  | Feed RSS                            | Geração automática de um feed RSS com as últimas plantas adicionadas ao sistema, permitindo que utilizadores externos acompanhem as novidades através de leitores de RSS                                            |
| G4  | Partilha em redes sociais           | Possibilidade de partilhar conteúdos de plantas em redes sociais (Facebook e Instagram) através de botões de partilha integrados na página de detalhe                                                               |
| G5  | Visualização em mapa                | Apresentação dos conteúdos num mapa interativo com base na zona climática ou região de origem da planta, permitindo ao utilizador explorar conteúdos geograficamente (ex. "que plantas crescem bem na minha zona?") |
| G6  | Identificação de plantas (PlantNet) | Integração com a API PlantNet para identificação automática de espécies                                                                                                                                             |
| G7  | Informação meteorológica            | Integração com um serviço meteorológico externo para apresentar condições atuais e previsões relevantes para o cultivo, associadas à localização                                                                    |
| G8  | Wizard de configuração              | Página de configuração inicial apresentada no primeiro arranque da aplicação num servidor limpo, orientando o administrador na criação da conta de administrador e configuração da base de dados e serviço de email |

### Resumo de Funcionalidades por Perfil

A tabela seguinte apresenta uma visão geral da hierarquia de permissões progressivas.

| Funcionalidade                            | Convidado | Utilizador | Moderador | Administrador |
| ----------------------------------------- | :-------: | :--------: | :-------: | :-----------: |
| Registar conta                            |     ✓     |     —      |     —     |       —       |
| Pesquisar e filtrar conteúdos públicos    |     ✓     |     ✓      |     ✓     |       ✓       |
| Ver detalhe de conteúdo público           |     ✓     |     ✓      |     ✓     |       ✓       |
| Autenticar (login/logout)                 |     —     |     ✓      |     ✓     |       ✓       |
| Ver conteúdo interno                      |     —     |     ✓      |     ✓     |       ✓       |
| Gerir perfil                              |     —     |     ✓      |     ✓     |       ✓       |
| Subscrever e gerir notificações           |     —     |     ✓      |     ✓     |       ✓       |
| Receber notificações por email            |     —     |     ✓      |     ✓     |       ✓       |
| Adicionar/editar/apagar plantas           |     —     |     —      |     ✓     |       ✓       |
| Definir visibilidade de conteúdos         |     —     |     —      |     ✓     |       ✓       |
| Criar/editar/apagar etiquetas secundárias |     —     |     —      |     ✓     |       ✓       |
| Criar/editar/apagar etiquetas principais  |     —     |     —      |     —     |       ✓       |
| Atribuir etiquetas e meta-informação      |     —     |     —      |     ✓     |       ✓       |
| Upload/download (unitário e em lote)      |     —     |     —      |     ✓     |       ✓       |
| Editar/apagar conteúdo global             |     —     |     —      |     ✓     |       ✓       |
| Adicionar/ver/editar/apagar utilizador    |     —     |     —      |     —     |       ✓       |
| Configurar base de dados e email          |     —     |     —      |     —     |       ✓       |

## Módulos e Componentes

A secção seguinte descreve a arquitetura do sistema, partindo do contexto geral até aos componentes internos da aplicação.

### Contexto do Sistema

O **Rooted** é uma aplicação web acedida exclusivamente via browser. Os utilizadores interagem com o sistema através de quatro perfis (Convidado, Utilizador, Moderador, Administrador). O sistema depende de quatro sistemas externos:

| Sistema Externo       | Finalidade                                                                      |
| --------------------- | ------------------------------------------------------------------------------- |
| Base de dados MySQL   | Armazenamento persistente de utilizadores, plantas, etiquetas e meta-informação |
| Servidor SMTP         | Envio de notificações por email e tokens de autenticação 2FA                    |
| PlantNet API          | Identificação automática de espécies a partir de fotografias                    |
| Serviço meteorológico | Obtenção de condições e previsões meteorológicas relevantes para o cultivo      |

### Contentores

O sistema é composto por dois contentores principais, orquestrados via Docker Compose:

| Contentor             | Tecnologia | Responsabilidade                                                                                                                                                             |
| --------------------- | ---------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Aplicação Web (`app`) | PHP 8.2    | Serve a aplicação web através do servidor embutido do PHP na porta 8080. Contém toda a lógica aplicacional, views e gestão do sistema de ficheiros para conteúdos multimédia |
| Base de Dados (`db`)  | MySQL 8.0  | Armazena todos os dados persistentes do sistema (utilizadores, plantas, etiquetas, subscrições, configurações)                                                               |

Os conteúdos multimédia (fotografias, vídeos, áudio) são armazenados no **sistema de ficheiros** do servidor, numa estrutura de diretórios organizada dentro do contentor da aplicação. A base de dados MySQL armazena toda a informação estruturada do sistema (utilizadores, plantas, etiquetas, subscrições, configurações) bem como as referências (caminhos) para os ficheiros multimédia no disco.

### Componentes

A aplicação PHP segue uma arquitetura inspirada no padrão MVC (Model-View-Controller), organizada nos seguintes componentes:

| Componente             | Responsabilidade                                                                                                                             |
| ---------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| Controller             | Ponto de entrada único para todos os pedidos HTTP. Inicializa a sessão, carrega dependências e delega o pedido ao Router                     |
| Router                 | Mapeia URIs e métodos HTTP aos controladores correspondentes. Suporta middlewares por rota                                                   |
| Middleware             | Controlo de acesso às rotas com base no estado de autenticação e perfil do utilizador                                                        |
| Contentor de Serviços  | Registo e resolução de dependências da aplicação (ex. instância da base de dados)                                                            |
| Sessão                 | Gestão do estado da sessão do utilizador, incluindo dados flash (erros de validação, valores anteriores)                                     |
| Autenticação           | Autenticação por password, gestão de sessões (login/logout) e verificação em dois fatores (2FA) por token enviado por email                  |
| Registo                | Criação de novas contas de utilizador com validação de dados                                                                                 |
| Gestão de Plantas      | Operações CRUD sobre plantas e respetivos conteúdos multimédia, incluindo definição de visibilidade e atribuição de etiquetas                |
| Gestão de Utilizadores | Operações CRUD sobre contas de utilizador, incluindo atribuição de perfis (restrito a administradores)                                       |
| Gestão de Etiquetas    | Criação, edição e remoção de etiquetas (principais e secundárias) para organização dos conteúdos, com controlo de permissões por perfil      |
| Notificações           | Gestão de subscrições a etiquetas e envio de emails automáticos quando novos conteúdos são adicionados. Comunica com o servidor SMTP         |
| Media                  | Upload e download de conteúdos multimédia para o sistema de ficheiros, tanto unitário como em lote (ficheiros ZIP com `metadata.xml`)        |
| RSS                    | Geração de feed RSS com as últimas plantas adicionadas ao sistema                                                                            |
| Serviços Externos      | Integração com APIs externas: PlantNet para identificação de plantas e serviço meteorológico para condições de cultivo                       |
| Validação              | Validação de dados de entrada (strings, emails, tamanhos) com suporte para apresentação de erros nos formulários                             |
| Base de Dados          | Abstração da ligação à base de dados MySQL via PDO, com suporte para queries parametrizadas                                                  |
| Views                  | Templates PHP responsáveis pela apresentação HTML, organizados em páginas e parciais reutilizáveis                                           |
| Configuração           | Definição dos parâmetros da aplicação (base de dados, email) e inicialização do contentor de serviços. Inclui wizard de configuração inicial |

### Sincronização e Interação entre Módulos

Os módulos da aplicação comunicam entre si segundo fluxos bem definidos. Descrevem-se abaixo os principais cenários de interação:

**Pedido HTTP genérico (fluxo base)**

1. O browser envia um pedido HTTP ao **Controller** (ponto de entrada único).
2. O Controller inicializa a **Sessão** e consulta o **Contentor de Serviços** para resolver dependências.
3. O pedido é delegado ao **Router**, que identifica a rota correspondente e aplica o **Middleware** adequado (ex. verificação de autenticação e perfil).
4. O Router invoca o controlador específico (ex. Gestão de Plantas), que interage com a **Base de Dados** e, se necessário, com o módulo de **Media** ou **Serviços Externos**.
5. O controlador seleciona a **View** apropriada, que renderiza a resposta HTML devolvida ao browser.

**Criação de uma planta com upload de conteúdo multimédia**

1. O Moderador submete o formulário de criação de planta com ficheiros anexos.
2. O módulo **Gestão de Plantas** valida os dados de entrada através do módulo de **Validação**.
3. O módulo **Media** recebe os ficheiros, armazena-os no **sistema de ficheiros** e regista os caminhos na **Base de Dados**.
4. O módulo **Gestão de Plantas** insere o registo da planta e associa as etiquetas e meta-informação indicadas.
5. O módulo de **Notificações** é acionado: consulta a tabela de subscrições para identificar utilizadores que subscreveram as etiquetas associadas à nova planta e delega o envio de emails ao **Servidor SMTP**.

**Upload em lote (ZIP)**

1. O Moderador envia um ficheiro `.zip` contendo conteúdos multimédia e um ficheiro `metadata.xml`.
2. O módulo **Media** extrai o arquivo, interpreta o ficheiro XML e valida a estrutura e os tipos de ficheiro.
3. Para cada conteúdo descrito no XML, o módulo armazena o ficheiro no sistema de ficheiros e cria os registos correspondentes na base de dados (planta, media, etiquetas, meta-informação).
4. As **Notificações** são despoletadas uma única vez, agregando todos os novos conteúdos do lote.

**Subscrição e notificação por email**

1. O Utilizador subscreve uma ou mais etiquetas através do módulo de **Notificações**, que regista as subscrições na **Base de Dados**.
2. Quando um novo conteúdo é adicionado (unitário ou em lote), o módulo de **Gestão de Plantas** notifica o módulo de **Notificações**.
3. O módulo de **Notificações** cruza as etiquetas do novo conteúdo com as subscrições ativas, compõe as mensagens e comunica com o **Servidor SMTP** para o envio efetivo.

**Autenticação com 2FA**

1. O utilizador submete as credenciais (email e password) ao módulo de **Autenticação**.
2. O módulo valida as credenciais contra a **Base de Dados**. Se válidas, gera um código temporário (2FA) e armazena-o na tabela `users`.
3. O código é enviado para o email do utilizador através do **Servidor SMTP**.
4. O utilizador introduz o código recebido; o módulo de **Autenticação** valida-o, cria a sessão e redireciona o utilizador para a área autenticada.

**Integração com Serviços Externos**

1. O módulo de **Serviços Externos** é invocado por controladores específicos (ex. página de detalhe de uma planta).
2. Para identificação de espécies, o módulo envia a fotografia à **PlantNet API** e devolve os resultados ao controlador.
3. Para informação meteorológica, o módulo consulta o **Serviço Meteorológico** com base na localização associada ao conteúdo e devolve as condições atuais e previsões.
4. Os resultados são incorporados na **View** correspondente.

## Estruturas de Dados

O sistema utiliza uma base de dados relacional MySQL para armazenar a informação estruturada e o sistema de ficheiros do servidor para armazenar os conteúdos multimédia. As principais entidades são descritas nas tabelas seguintes.

### Utilizador (`users`)

Representa uma conta registada no sistema.

| Atributo                | Tipo         | Descrição                                          |
| ----------------------- | ------------ | -------------------------------------------------- |
| `id`                    | INT          | Identificador único                                |
| `email`                 | VARCHAR(255) | Endereço de email (único)                          |
| `password`              | VARCHAR(255) | Hash da password                                   |
| `role`                  | ENUM         | Perfil do utilizador: `admin`, `moderator`, `user` |
| `two_factor_code`       | VARCHAR(6)   | Código temporário para autenticação 2FA            |
| `two_factor_expires_at` | DATETIME     | Data de expiração do código 2FA                    |
| `email_verified`        | TINYINT(1)   | Indica se o email foi verificado                   |
| `created_at`            | TIMESTAMP    | Data de criação                                    |
| `updated_at`            | TIMESTAMP    | Data da última atualização                         |

### Planta (`plants`)

Representa uma entrada de planta criada por um moderador.

| Atributo     | Tipo         | Descrição                                        |
| ------------ | ------------ | ------------------------------------------------ |
| `id`         | INT          | Identificador único                              |
| `user_id`    | INT (FK)     | Referência ao utilizador que criou a planta      |
| `name`       | VARCHAR(255) | Nome da planta                                   |
| `body`       | TEXT         | Descrição textual da planta                      |
| `visibility` | ENUM         | Visibilidade do conteúdo: `public` ou `internal` |
| `created_at` | TIMESTAMP    | Data de criação                                  |
| `updated_at` | TIMESTAMP    | Data da última atualização                       |

### Conteúdo Multimédia (`media`)

Armazena as referências aos ficheiros multimédia (fotografias, vídeos, áudio) associados a uma planta. Os ficheiros são guardados no sistema de ficheiros do servidor.

| Atributo     | Tipo         | Descrição                                             |
| ------------ | ------------ | ----------------------------------------------------- |
| `id`         | INT          | Identificador único                                   |
| `plant_id`   | INT (FK)     | Referência à planta associada                         |
| `type`       | ENUM         | Tipo de conteúdo: `image`, `video`, `audio`           |
| `path`       | VARCHAR(500) | Caminho relativo do ficheiro no sistema de ficheiros  |
| `filename`   | VARCHAR(255) | Nome original do ficheiro                             |
| `mime_type`  | VARCHAR(100) | Tipo MIME do ficheiro (ex. `image/jpeg`, `video/mp4`) |
| `created_at` | TIMESTAMP    | Data de criação                                       |

### Etiqueta (`tags`)

Representa uma etiqueta utilizada para organizar os conteúdos. As etiquetas dividem-se em dois tipos: **principais**, criadas e geridas exclusivamente por administradores, e **secundárias**, criadas por moderadores.

| Atributo     | Tipo         | Descrição                                                           |
| ------------ | ------------ | ------------------------------------------------------------------- |
| `id`         | INT          | Identificador único                                                 |
| `name`       | VARCHAR(100) | Nome da etiqueta (único)                                            |
| `type`       | ENUM         | Tipo de etiqueta: `primary` (principal) ou `secondary` (secundária) |
| `user_id`    | INT (FK)     | Referência ao utilizador que criou a etiqueta                       |
| `created_at` | TIMESTAMP    | Data de criação                                                     |

### Etiqueta–Planta (`plant_tag`)

Tabela associativa que estabelece a relação muitos-para-muitos entre plantas e etiquetas.

| Atributo   | Tipo     | Descrição             |
| ---------- | -------- | --------------------- |
| `plant_id` | INT (FK) | Referência à planta   |
| `tag_id`   | INT (FK) | Referência à etiqueta |

### Meta-informação (`plant_meta`)

Armazena pares chave–valor de informação descritiva livre associada a uma planta.

| Atributo   | Tipo         | Descrição                                                         |
| ---------- | ------------ | ----------------------------------------------------------------- |
| `id`       | INT          | Identificador único                                               |
| `plant_id` | INT (FK)     | Referência à planta                                               |
| `key`      | VARCHAR(100) | Chave da meta-informação (ex. "Solo", "Rega", "Zona climática")   |
| `value`    | VARCHAR(255) | Valor da meta-informação (ex. "Argiloso", "Semanal", "Temperada") |

### Subscrição (`subscriptions`)

Regista a subscrição de um utilizador a uma etiqueta para efeitos de notificação.

| Atributo     | Tipo      | Descrição                       |
| ------------ | --------- | ------------------------------- |
| `id`         | INT       | Identificador único             |
| `user_id`    | INT (FK)  | Referência ao utilizador        |
| `tag_id`     | INT (FK)  | Referência à etiqueta subscrita |
| `created_at` | TIMESTAMP | Data da subscrição              |

### Configuração (`settings`)

Armazena os parâmetros de configuração da aplicação (base de dados, serviço de email).

| Atributo | Tipo         | Descrição                                                         |
| -------- | ------------ | ----------------------------------------------------------------- |
| `id`     | INT          | Identificador único                                               |
| `key`    | VARCHAR(100) | Chave da configuração (ex. `smtp_host`, `smtp_port`, `smtp_user`) |
| `value`  | TEXT         | Valor da configuração                                             |

### Relações entre Entidades

- Um **moderador** pode criar várias **plantas** (1:N)
- Uma **planta** pode ter vários **conteúdos multimédia** (1:N)
- Uma **planta** pode ter várias **etiquetas** e uma **etiqueta** pode estar associada a várias **plantas** (N:M, via `plant_tag`)
- Uma **planta** pode ter vários pares de **meta-informação** (1:N)
- Um **utilizador** pode subscrever várias **etiquetas** (N:M, via `subscriptions`)
- Um **utilizador** (administrador ou moderador) pode criar várias **etiquetas** (1:N)

## Anexos

> **Nota:** Esta secção será completada após a implementação da aplicação, com os diagramas e exemplos definitivos que reflitam a solução final.

### Diagramas de Arquitetura

Os diagramas C4 (Contexto, Contentores e Componentes) que ilustram graficamente a arquitetura descrita nas secções anteriores serão adicionados após a conclusão do desenvolvimento.

### Esquema XML para Upload em Lote

A estrutura do ficheiro `metadata.xml` utilizado nas operações de upload e download em lote (M11, M13) será documentada nesta secção, incluindo um exemplo representativo e a descrição dos elementos XML suportados.

# Desenvolvimento da Aplicação Web

<!--TODO-->

# Testes

<!--TODO-->
