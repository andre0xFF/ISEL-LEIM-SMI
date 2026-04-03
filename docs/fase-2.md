# Análise do Problema

O projeto **Rooted** consiste no desenvolvimento de um Sistema de Gestão de Conteúdos (SGC) orientado à partilha de conteúdos multimédia no domínio da jardinagem e botânica. A aplicação permite que utilizadores partilhem fotografias, vídeos e áudio relacionados com plantas, jardins e técnicas de cultivo, cada um acompanhado de descrições textuais e meta-informação relevante.

O sistema é acedido exclusivamente através de um browser e suporta quatro perfis de utilização com níveis de permissão progressivos: **Convidado**, **Utilizador**, **Moderador** (equivalente ao perfil Simpatizante) e **Administrador**. Cada perfil herda as funcionalidades do perfil anterior, adicionando capacidades específicas.

Os conteúdos são organizados por **etiquetas** (e.g. "Flores", "Hortícolas", "Suculentas", "Rega Gota-a-Gota", "Cultivo Interior"), que podem ser criadas tanto por administradores como por moderadores. Adicionalmente, os moderadores podem associar **meta-informação** livre a cada conteúdo (tipo de solo, exposição solar, frequência de rega, entre outros).

## Funcionalidades do Sistema

O sistema foi desenhado em torno de quatro perfis de utilização com permissões progressivas. Cada perfil herda todas as funcionalidades do anterior. Além disso, a aplicação oferece um conjunto de funcionalidades transversais que não estão associadas a um perfil específico.

### Convidado

O Convidado é o perfil mais restritivo. Não requer autenticação e destina-se a visitantes que pretendem explorar os conteúdos públicos disponíveis na plataforma.

| #   | Funcionalidade              | Descrição                                                                                                                                |
| --- | --------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| C1  | Pesquisar plantas           | Pesquisa de plantas através de texto livre, com resultados baseados em nomes, descrições e meta-informação associada aos conteúdos       |
| C2  | Filtrar por etiqueta        | Navegação e filtragem dos conteúdos públicos com base nas etiquetas associadas                                                           |
| C3  | Filtrar por meta-informação | Filtragem dos conteúdos com base em meta-informação associada (e.g. tipo de solo, exposição solar)                                       |
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
| U5  | Gerir perfil                   | Edição dos dados pessoais (nome, email, password) e preferências de notificação (e.g. frequência de emails, etiquetas de interesse)      |
| U6  | Ver conteúdo interno           | Visualização da página de detalhe de uma planta, incluindo os seus conteúdos multimédia (fotografias, vídeos, áudio) e descrição textual |

### Moderador

O Moderador (equivalente ao perfil _Simpatizante_ descrito no enunciado) é o principal criador de conteúdos da plataforma. Pode adicionar, editar e gerir plantas e respetivos conteúdos multimédia, bem como criar etiquetas e definir a visibilidade dos seus conteúdos.

| #   | Funcionalidade            | Descrição                                                                                                                                              |
| --- | ------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| M1  | Adicionar planta          | Criação de uma nova entrada de planta no sistema, com nome, descrição textual e conteúdos multimédia (fotografia, vídeo ou áudio)                      |
| M2  | Editar planta             | Modificação dos dados de uma planta existente, incluindo a sua descrição e conteúdos multimédia                                                        |
| M3  | Apagar planta             | Remoção de uma planta e todos os conteúdos associados do sistema                                                                                       |
| M4  | Definir visibilidade      | Associação de visibilidade **pública** ou **interno** a cada conteúdo                                                                                  |
| M5  | Criar etiquetas           | Criação de novas etiquetas para organizar os conteúdos do sistema                                                                                      |
| M6  | Editar etiqueta           | Modificação do nome ou descrição de uma etiqueta existente                                                                                             |
| M7  | Apagar etiqueta           | Remoção de uma etiqueta do sistema e desassociação dos conteúdos correspondentes                                                                       |
| M8  | Atribuir etiquetas        | Associação de etiquetas aos conteúdos enviados para o sistema                                                                                          |
| M9  | Adicionar meta-informação | Associação de informação descritiva livre aos conteúdos (e.g. "Solo: argiloso", "Rega: semanal", "Zona climática: temperada")                          |
| M10 | Upload unitário           | Envio de um único conteúdo multimédia com a respetiva meta-informação através de formulário                                                            |
| M11 | Upload em lote (ZIP)      | Envio de múltiplos conteúdos agrupados num ficheiro `.zip`, acompanhados de um ficheiro `metadata.xml` que descreve a meta-informação de cada conteúdo |
| M12 | Download unitário         | Obtenção de um conteúdo multimédia individual do sistema                                                                                               |
| M13 | Download em lote (ZIP)    | Obtenção de múltiplos conteúdos agrupados num ficheiro `.zip`, incluindo um ficheiro `metadata.xml` com a meta-informação correspondente               |
| M14 | Editar conteúdo global    | Modificação de qualquer conteúdo no sistema, independentemente do autor                                                                                |
| M15 | Apagar conteúdo global    | Remoção de qualquer conteúdo no sistema, independentemente do autor                                                                                    |

### Administrador

O Administrador possui privilégios totais sobre o sistema. Para além de todas as funcionalidades anteriores, é responsável pela gestão de utilizadores, etiquetas e configurações globais da aplicação.

| #   | Funcionalidade              | Descrição                                                                                                 |
| --- | --------------------------- | --------------------------------------------------------------------------------------------------------- |
| A1  | Adicionar utilizador        | Criação de uma nova conta de utilizador com atribuição de perfil (Utilizador, Moderador ou Administrador) |
| A2  | Ver utilizador              | Visualização dos dados de qualquer conta de utilizador registada no sistema                               |
| A3  | Editar utilizador           | Modificação dos dados de uma conta de utilizador, incluindo a alteração do perfil atribuído               |
| A4  | Apagar utilizador           | Remoção de uma conta de utilizador e respetivos dados associados do sistema                               |
| A5  | Configurar base de dados    | Definição dos parâmetros de acesso à base de dados (host, porta, nome da base de dados, credenciais)      |
| A6  | Configurar serviço de email | Configuração do servidor SMTP e credenciais utilizados para o envio de notificações por email             |

### Funcionalidades Gerais da Aplicação

Para além das funcionalidades associadas a cada perfil, o sistema inclui um conjunto de funcionalidades transversais.

| #   | Funcionalidade                      | Descrição                                                                                                                                                                                                            |
| --- | ----------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| G1  | Autenticação por password           | Autenticação convencional através de email e password                                                                                                                                                                |
| G2  | Autenticação por token (2FA)        | Autenticação em dois fatores: é enviado um token por email que o utilizador deve introduzir para confirmar a sessão                                                                                                  |
| G3  | Feed RSS                            | Geração automática de um feed RSS com as últimas plantas adicionadas ao sistema, permitindo que utilizadores externos acompanhem as novidades através de leitores de RSS                                             |
| G4  | Partilha em redes sociais           | Possibilidade de partilhar conteúdos de plantas em redes sociais (Facebook e Instagram) através de botões de partilha integrados na página de detalhe                                                                |
| G5  | Visualização em mapa                | Apresentação dos conteúdos num mapa interativo com base na zona climática ou região de origem da planta, permitindo ao utilizador explorar conteúdos geograficamente (e.g. "que plantas crescem bem na minha zona?") |
| G6  | Identificação de plantas (PlantNet) | Integração com a API PlantNet para identificação automática de espécies                                                                                                                                              |
| G7  | Informação meteorológica            | Integração com um serviço meteorológico externo para apresentar condições atuais e previsões relevantes para o cultivo, associadas à localização                                                                     |
| G8  | Wizard de configuração              | Página de configuração inicial apresentada no primeiro arranque da aplicação num servidor limpo, orientando o administrador na criação da conta de administrador e configuração da base de dados e serviço de email  |

### Resumo de Funcionalidades por Perfil

A tabela seguinte apresenta uma visão geral da hierarquia de permissões. Cada perfil herda as funcionalidades de todos os perfis anteriores.

| Funcionalidade                         | Convidado | Utilizador | Moderador | Administrador |
| -------------------------------------- | :-------: | :--------: | :-------: | :-----------: |
| Registar conta                         |     ✓     |     —      |     —     |       —       |
| Pesquisar e filtrar conteúdos públicos |     ✓     |     ✓      |     ✓     |       ✓       |
| Ver detalhe de conteúdo público        |     ✓     |     ✓      |     ✓     |       ✓       |
| Autenticar (login/logout)              |     —     |     ✓      |     ✓     |       ✓       |
| Ver conteúdo interno                   |     —     |     ✓      |     ✓     |       ✓       |
| Gerir perfil                           |     —     |     ✓      |     ✓     |       ✓       |
| Subscrever e gerir notificações        |     —     |     ✓      |     ✓     |       ✓       |
| Receber notificações por email         |     —     |     ✓      |     ✓     |       ✓       |
| Adicionar/editar/apagar plantas        |     —     |     —      |     ✓     |       ✓       |
| Definir visibilidade de conteúdos      |     —     |     —      |     ✓     |       ✓       |
| Adicionar/editar/apagar etiquetas      |     —     |     —      |     ✓     |       ✓       |
| Atribuir etiquetas e meta-informação   |     —     |     —      |     ✓     |       ✓       |
| Upload/download (unitário e em lote)   |     —     |     —      |     ✓     |       ✓       |
| Editar/apagar conteúdo global          |     —     |     —      |     ✓     |       ✓       |
| Adicionar/ver/editar/apagar utilizador |     —     |     —      |     —     |       ✓       |
| Configurar base de dados e email       |     —     |     —      |     —     |       ✓       |

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

| Contentor             | Tecnologia | Responsabilidade                                                                                                   |
| --------------------- | ---------- | ------------------------------------------------------------------------------------------------------------------ |
| Aplicação Web (`app`) | PHP 8.2    | Serve a aplicação web através do servidor embutido do PHP na porta 8080. Contém toda a lógica aplicacional e views |
| Base de Dados (`db`)  | MySQL 8.0  | Armazena todos os dados persistentes do sistema (utilizadores, plantas, etiquetas, subscrições, configurações)     |

Todos os dados do sistema, incluindo os conteúdos multimédia (fotografias, vídeos, áudio) e a respetiva meta-informação, são armazenados na base de dados MySQL.

### Componentes

A aplicação PHP segue uma arquitetura inspirada no padrão MVC (Model-View-Controller), organizada nos seguintes componentes:

| Componente             | Responsabilidade                                                                                                                             |
| ---------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| Controller             | Ponto de entrada único para todos os pedidos HTTP. Inicializa a sessão, carrega dependências e delega o pedido ao Router                     |
| Router                 | Mapeia URIs e métodos HTTP aos controladores correspondentes. Suporta middlewares por rota                                                   |
| Middleware             | Controlo de acesso às rotas com base no estado de autenticação e perfil do utilizador                                                        |
| Contentor de Serviços  | Registo e resolução de dependências da aplicação (e.g. instância da base de dados)                                                           |
| Sessão                 | Gestão do estado da sessão do utilizador, incluindo dados flash (erros de validação, valores anteriores)                                     |
| Autenticação           | Autenticação por password, gestão de sessões (login/logout) e verificação em dois fatores (2FA) por token enviado por email                  |
| Registo                | Criação de novas contas de utilizador com validação de dados                                                                                 |
| Gestão de Plantas      | Operações CRUD sobre plantas e respetivos conteúdos multimédia, incluindo definição de visibilidade e atribuição de etiquetas                |
| Gestão de Utilizadores | Operações CRUD sobre contas de utilizador, incluindo atribuição de perfis (restrito a administradores)                                       |
| Gestão de Etiquetas    | Criação, edição e remoção de etiquetas para organização dos conteúdos                                                                        |
| Notificações           | Gestão de subscrições a etiquetas e envio de emails automáticos quando novos conteúdos são adicionados. Comunica com o servidor SMTP         |
| Media                  | Upload e download de conteúdos multimédia, tanto unitário como em lote (ficheiros ZIP com `metadata.xml`)                                    |
| RSS                    | Geração de feed RSS com as últimas plantas adicionadas ao sistema                                                                            |
| Serviços Externos      | Integração com APIs externas: PlantNet para identificação de plantas e serviço meteorológico para condições de cultivo                       |
| Validação              | Validação de dados de entrada (strings, emails, tamanhos) com suporte para apresentação de erros nos formulários                             |
| Base de Dados          | Abstração da ligação à base de dados MySQL via PDO, com suporte para queries parametrizadas                                                  |
| Views                  | Templates PHP responsáveis pela apresentação HTML, organizados em páginas e parciais reutilizáveis                                           |
| Configuração           | Definição dos parâmetros da aplicação (base de dados, email) e inicialização do contentor de serviços. Inclui wizard de configuração inicial |

## Estruturas de Dados

O sistema utiliza uma base de dados relacional MySQL para armazenar todos os dados, incluindo conteúdos multimédia. As principais entidades são descritas nas tabelas seguintes.

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

Armazena os ficheiros multimédia (fotografias, vídeos, áudio) associados a uma planta.

| Atributo     | Tipo         | Descrição                                              |
| ------------ | ------------ | ------------------------------------------------------ |
| `id`         | INT          | Identificador único                                    |
| `plant_id`   | INT (FK)     | Referência à planta associada                          |
| `type`       | ENUM         | Tipo de conteúdo: `image`, `video`, `audio`            |
| `data`       | LONGBLOB     | Conteúdo binário do ficheiro multimédia                |
| `filename`   | VARCHAR(255) | Nome original do ficheiro                              |
| `mime_type`  | VARCHAR(100) | Tipo MIME do ficheiro (e.g. `image/jpeg`, `video/mp4`) |
| `created_at` | TIMESTAMP    | Data de criação                                        |

### Etiqueta (`tags`)

Representa uma etiqueta utilizada para organizar os conteúdos.

| Atributo     | Tipo         | Descrição                |
| ------------ | ------------ | ------------------------ |
| `id`         | INT          | Identificador único      |
| `name`       | VARCHAR(100) | Nome da etiqueta (único) |
| `created_at` | TIMESTAMP    | Data de criação          |

### Etiqueta–Planta (`plant_tag`)

Tabela associativa que estabelece a relação muitos-para-muitos entre plantas e etiquetas.

| Atributo   | Tipo     | Descrição             |
| ---------- | -------- | --------------------- |
| `plant_id` | INT (FK) | Referência à planta   |
| `tag_id`   | INT (FK) | Referência à etiqueta |

### Meta-informação (`plant_meta`)

Armazena pares chave–valor de informação descritiva livre associada a uma planta.

| Atributo   | Tipo         | Descrição                                                          |
| ---------- | ------------ | ------------------------------------------------------------------ |
| `id`       | INT          | Identificador único                                                |
| `plant_id` | INT (FK)     | Referência à planta                                                |
| `key`      | VARCHAR(100) | Chave da meta-informação (e.g. "Solo", "Rega", "Zona climática")   |
| `value`    | VARCHAR(255) | Valor da meta-informação (e.g. "Argiloso", "Semanal", "Temperada") |

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

| Atributo | Tipo         | Descrição                                                          |
| -------- | ------------ | ------------------------------------------------------------------ |
| `id`     | INT          | Identificador único                                                |
| `key`    | VARCHAR(100) | Chave da configuração (e.g. `smtp_host`, `smtp_port`, `smtp_user`) |
| `value`  | TEXT         | Valor da configuração                                              |

### Relações entre Entidades

- Um **moderador** pode criar várias **plantas** (1:N)
- Uma **planta** pode ter vários **conteúdos multimédia** (1:N)
- Uma **planta** pode ter várias **etiquetas** e uma **etiqueta** pode estar associada a várias **plantas** (N:M, via `plant_tag`)
- Uma **planta** pode ter vários pares de **meta-informação** (1:N)
- Um **utilizador** pode subscrever várias **etiquetas** (N:M, via `subscriptions`)

# Desenvolvimento da Aplicação Web

<!--TODO-->

# Testes

<!--TODO-->
