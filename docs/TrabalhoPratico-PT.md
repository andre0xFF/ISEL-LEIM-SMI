## Instituto Superior de Engenharia de Lisboa

### Departamento de Engenharia Informática

```
Licenciatura em Engenharia Informática e Multimédia
```
#### Sistemas Multimédia para a Internet – Semestre de Verão 2025/

```
Trabalho Prático
```
## Objetivos

```
 Pretende-se que o aluno seja capaz de estudar e resumir as características fundamentais de
tecnologias relevantes e/ou emergentes nas áreas de:
o Sistemas de Gestão de Conteúdos (SGC) / Content Management System (CMS);
o Web Services.
 Consolidação dos conceitos sobre a linguagem/infra-estrutura PHP apresentados nas aulas;
 Estruturação de aplicações Web dinâmicas e Sistemas de Gestão de Conteúdos;
 Interligação de aplicações Web com sistemas externos, por exemplo:
o Bases de Dados;
o Correio Eletrónico;
o Web Services;
 Visualização de conteúdos multimédia;
 Estruturação de aplicações distribuídas segundo o modelo cliente/servidor;
 Consolidação dos conceitos sobre Web Services;
```
#### Realização do trabalho:

Os alunos organizam-se segundo os grupos de trabalho das aulas práticas. Sugere-se que cada
grupo tenha 2 elementos. A realização do trabalho é conjunta, ficando cada um dos elementos do
grupo corresponsável técnico da solução adotada, porém recomenda-se vivamente que o grupo
distribua equitativamente entre si as atividades de desenvolvimento (execução paralela); esta
distribuição também será objeto de avaliação do trabalho. Por cada fase do trabalho devem
compactados num único ficheiro todos os recursos produzidos (relatórios, código produzido, etc.) e
entregar os mesmos na página Moodle da sua turma. As datas de entrega das várias fases
encontram-se disponíveis na página Moodle correspondente à sua turma.

#### Contexto:

Um Sistema de Gestão de Conteúdos (SGC) é um sistema que permite a gestão de sítios web,
seja na forma de um sítio que apresenta uma organização, suporta uma rede social, um blog ou um
wiki. Pode-se mesmo dizer que um SGC é um esqueleto de um sítio, que através de algumas
configurações fica pronto a ser utilizado.


Uma das características dos SGC que os tornam tão apelativos é o facto de permitiram a edição
dos seus conteúdos sem que os utilizadores tenham de ter conhecimentos das tecnologias que
suportam os SCG (sejam eles a linguagem HTML ou os sistemas auxiliares tais como bases de dados
ou sistemas de autenticação externos).

Pretende-se um Sistema de Gestão de Conteúdos – SGC (Content Management System – CMS)
que de forma simples e robusta implemente um sítio que permita a “partilha de conteúdos
multimédia”, tais como fotografias, vídeos ou sons. O sistema a desenvolver será acedido única e
exclusivamente utilizando um browser (quer por parte dos convidados, utilizadores, simpatizantes ou
administradores).

## 1ª Parte

Nos links apresentados em anexo encontra várias listas de SGC. As listas podem ser ordenadas
por funcionalidades (por exemplo sítios web, construção de blogs, suporte de redes sociais, suporte
de wikis ou e-learning) por tecnologias utilizadas (por exemplo Java, PHP, MySQL, C#, etc.) ou tipo
de licença de software que abrange o SGC. Pretende-se que escolha um conjunto de SGC (entre 1 a
3) que permitam implementar um sistema equivalente ao desenvolvido na 2ª parte do trabalho.
Compare as funcionalidades/arquitetura dos SGC escolhidos com a implementação que se propõem a
desenvolver na segunda parte do trabalho.

```
 http://www.opensourcecms.com/
 http://en.wikipedia.org/wiki/List_of_content_management_frameworks
 http://www.cmsmadesimple.org/about-link/
```

## 2ª Parte

Pretende-se o desenvolvimento de um Sistema de Gestão de Conteúdos que suporte, de forma
simples e robusta, um sítio de “partilha de conteúdos multimédia” acessível via browser. Cada
conteúdo (fotografia, vídeo ou áudio) poderá estar associado uma descrição textual. Na figura 1
apresentam-se as entidades que poderão estar envolvidas na solução.

```
Figura 1 – Entidades envolvidas na solução
```
O sistema a desenvolver admite 4 perfis de utilização: administrador, com privilégios para
realizar todo o tipo de operações; utilizador, apenas com privilégios para visualizar os conteúdos
multimédia; simpatizante com possibilidade adicionar novos conteúdos, gerir os seus conteúdos
(apagar, modificar, etc.); e convidado, que não necessita de autenticação, e que pode apenas
visualizar e pesquisar os conteúdos públicos. Os eventos ao serem inseridos no sistema ficam
associados a uma ou mais categorias. O sistema suporta categorias principais (definidas pelos
administradores) e categorias secundárias (definidas pelos simpatizantes). Além das categorias os
simpatizantes podem ainda associar meta informação (descrições livre) aos conteúdos. Consoante o
perfil de utilizadores o sistema deverá suportar as seguintes funcionalidades:
 Convidado – este perfil é o mais restritivo de todos e apenas permite visualizar e pesquisar
os conteúdos públicos disponíveis no sistema. As pesquisas podem ser efetuadas com base
nas categorias e meta informação associada aos conteúdos.
 Utilizador – este perfil inclui as funcionalidades do perfil anterior e acrescenta as seguintes:
o Subescrever notificações de novos eventos ao sistema. Os utilizadores só serão
notificados se os novos eventos coincidirem com os interesses dos utilizadores.


```
 Simpatizante – este perfil inclui as funcionalidades do perfil anterior e acrescenta as
seguintes:
o Criação de categorias secundárias
o Associação de categorias (principais e secundárias) e meta informação aos conteúdos
que são enviados para o servidor
o Obter conteúdos do sistema
o Envio de conteúdos para o sistema
o Associação de visibilidade (pública ou privada) aos conteúdos
 Administrador – este perfil de utilizador adiciona às funcionalidades anteriores as seguintes:
o Definições de acesso à base de dados
o Configurações do serviço de correio eletrónico
o Gestão das categorias de conteúdos
o Gestão de utilizadores
```
A obtenção e o envio de conteúdos multimédia pode ser realizado de forma unitária ou em
lote. No caso de serem efetuados em lote os conteúdos, bem como a sua meta informação, são
agrupados num único ficheiro com a extensão ZIP. A meta informação de todos os conteúdos é
agrupada num único ficheiro XML.

Além das funcionalidades descritas anteriormente o sistema poderá incluir as seguintes:
 Instalação e configuração do SGC num servidor web vazio;
 Registo de novos utilizadores de forma automática;
 Envio de mensagens, para os utilizadores registados, sempre que se adicionam conteúdos em
categorias pré-definidas;
 Criação de RSS (Rich Site Summary) quando se inserem novos conteúdos;
 Partilha dos conteúdos em redes sociais (tais como Facebook e Twitter);
 Visualização num mapa (utilizando por exemplo a API Google Maps) do local associado ao
conteúdo;
 Possibilidade de a adição de novas funcionalidades serem fornecidas por componentes
externos que são acedidos através de Web Services, por exemplo possibilidade de tradução de
texto, ou a gestão de um livro de convidados que registe o número de visitas por país.
 Outros que achar interessantes;


Para gerir e armazenar os dados recorra: ao sistema de gestão de ficheiros, para armazenar os
conteúdos multimédia; e a um sistema de base de dados, para armazenar a informação sobre os
conteúdos e definições do sistema.

## Implementação

O Trabalho deve ser realizado nas seguintes fases:

1. Análise do problema:
    a. Identificação dos principais módulos/componentes;
    b. Identificação das funcionalidades suportadas pelo sistema;
    c. Estruturas de dados utilizados;
2. Desenvolvimento da aplicação Web para disponibilizar as funcionalidades indicadas
3. Testes que comprovem o correto funcionamento da aplicação

#### Notas Importantes:

Antes de passar à fase 2, os grupos devem validar junto do professor a análise efetuada bem
como planeiam efetuar os desenvolvimentos posteriores (fase 2 e 3).

Salienta-se que devem ser descritos e/ou esquematizados pormenorizadamente, no relatório,
a arquitetura escolhida para resolver os vários problemas encontrados, bem como, as estruturas de
dados adotadas e os modos de sincronização existentes entre os vários módulos.

O relatório deve incluir obrigatoriamente exemplos de teste que cubram casos de utilização
corrente e os casos especiais que sejam considerados pertinentes.
São fatores importantes na avaliação do relatório a organização e clareza das decisões tomadas.

```
Bom Trabalho
```
# Carlos Gonçalves,

# Jéssica Corujeira &

# Tiago Gonçalves
