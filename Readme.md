# Conteúdo

1 O que é BDD ?

2 O que é Behat ?

3 Uso básico do Behat

4 Indo além...


# O que é BDD ?

Não é apenas testar as funcionalidades do sistema, e sim garantir que as
necessidades do cliente foram supridas com a entrega.

* Metodo Ágil => Estória BDD = User Story

* Estória do BDD ajuda os desenvolvedores a entenderem as regras de negócio.


# BDD agrega...

Dev + QA + Business Team + Client

* Uso de linguagem ubiqua junto a nativa:

    * Melhoria de comunicação entre áreas

    * Melhoria de escopo e documentação do produto

# Desenvolver com BDD

Desenvolvimento de Fora para Dentro

* Guiado ao desenvolvimento de entregável que agrege valor ao negócio


# BDD - Vantagens

A qualidade na utilização do BDD, se dá no quanto você entende e aplica as
necessidades e definições da área de negócio, corretamente nas definições da feature

* Utilização de exemplos para descrever o comportamento da feature

* Automatização dos exemplos, a fim de garantir o funcionamento do entregável

* Compreensão da área de negócio em relação ao que está sendo desenvolvido e entregue


# BDD - Definições

BDD se utiliza da linguaguem ubiqua, e basicamente se estrutura em 3 niveis para definição dos requisitos:

* <strong>Feature</strong> - narrativa da feature (estória)
* <strong>Scenarios</strong> - descrição de um cenário da feature
* <strong>Detalhamento</strong> - detalhes que uma situação de execução do processo

Essas definições de requisitos são utilizadas no <strong>framework</strong> para o desenvolvimento BDD

# O que é Behat ?

- PHP BDD Framework

- Inspirado no Cucumber - Ruby

- Com o behat você descreve suas features, utilizando as estorias criadas pela
  área de negócio ou de projetos, define os cenarios que podem ocorrer para a
  feature e cria métodos para execução das etapas do fluxo.


# BDD / Behat - Pensando nas features

Para utilização do framework temos que definir a feature a ser entregue.

No Behat, e no Cucumber, a sintax utilizada para descrever as features é o Gherkin.

A especificação da feature, pode ser descrita partindo de respostas de negócio relativas a feature:

1. For who - Para quem ?
2. What - O que ?
3. Who - Como ?

# BDD / Behat - Especificando features

- Feature é descrita com:
    - Beneficio da feature (what)
    - Quem vai executar o processo e ser beneficiado (who)
    - O que é necessário para o fluxo da feature ser realizado (how)

# BDD / Behat - Especificando cenários

Cada feature possui fluxos e resultados diferentes em seu processo

Para cada situação dessas, é definido um cenário para a feature

É utilizado o formato Given / When / Then para descrição dos cenários

- <strong>Given</strong>: pré-condições para o cenário
- <strong>When</strong>: eventos que devem ocorrer para execução do cenário
- <strong>Then</strong>: resultados da execução do cenário


# Vamos a prática ...

Colocando a mão na massa...


# Uso básico do Behat

Vamos realizar um teste simples com uma lib do <strong>knplabs</strong> para conectar a api do github:

    # composer.json
    {
        "name": "dafiti/bdd",
        "description": "Bdd Tutorial for Dafiti",
        "require": {
            "knplabs/github-api": "*",
            "behat/behat": "2.4.*@stable",
        },
        "minimum-stability": "dev",
        "config": {
            "bin-dir": "bin/"
        }
    }


# Iniciando o Behat

    # command line
    composer install
    behat --init

Após instalar o composer e iniciar o behat, é adicionado à pasta do projeto a seguinte estrutura:

    \features
       \bootstrap
            FeatureContext.php

Agora podemos criar nossas features e seus cenários:

    \features\bootstrap\github.feature


# Behat - Feature

Vamos descrever uma feature que ira usar essa lib para consultar dados
referentes a repositórios no github:

    Feature: Get repositories from github
        In order to check code on github
        As a developer
        I want to get code from repositories


# Behat - Cenário

Agora, vamos escrever nosso primeiro cenário, buscando os repositórios da
conta DafitSprint:

    Scenario: Get DafitiSprint repositories info
        Given I get app to connect to Github
        When I call info for public repositories from "DafitiSprint"
        Then I get "1" repositorie(s)
        And repository name is "dojos"

Cada linha de definição no cenário exige que exista um método para processá-lo.


# Behat - Implementando as etapas

Executando behat, é apresentado os passos que possuem métodos definidos.

A própria ferramenta já cria snippets para serem implementados, na class FeatureContext:

    /**
     * @Given /^I get app to connect to Github$/
     */
    public function iGetAppToConnectToGithub()
    {
        throw new PendingException();
    }

O Behat não possui ferramentas de validação.
Recomenda-se PHPUnit.

# Mink - Behat na camada http/browser

O Behat por si só não atua no protocolo http ou no browser, para isso existe o Mink.

- Mink - Extensão para abstração da camada http/browser
    - Remove diferenças entre apis dos browsers e emuladores
    - Fácil controle do browser - navegação, sessão, etc...
    - Drives
        - GoutteDriver - Bridge para Goutte (Symfony)
        - Selenium2Driver - Bridge para Selenium webdriver
        - ...


# Behat + Mink na prática

Precimos adicionar as dependencias do Mink:

    # composer.json
        "require": {
            "behat/mink": "1.4@stable",
            "behat/mink-extension": "*",
            "behat/mink-goutte-driver": "*",
            "behat/mink-selenium2-driver": "*"
        },


Vamos criar uma nova feature para os novos testes:

    \features\bootstrap\dafiti.feature

# FeatureContext extendendo Mink

Também vamos extender a classe MinkContext a FeatureContext

    use Behat\MinkExtension\Context\MinkContext;

        class FeatureContext extends MinkContext {}

Devemos criar o arquivo behat.yml, para definir o autoload das extensões do mink e dos drivers:

    # behat.yml
    default:
        extensions:
            Behat\MinkExtension\Extension:
                base_url: http://dafiti.com.br
                goutte: ~
                selenium2: ~


# Feature e Cenários para o Mink

No terminal, podemos visualizar a lista de definições pré definidas do Mink

    behat -dl


# Mink com Goutee

Goutte é um driver que faz uma requisição HTTP e parsea o conteúdo retornado.

Sem Javascript, Ajax, UI.

Feature e cenário para aplicação usando mink + goutee:

    Feature: Navigation on Dafiti
        In order to ensure dafiti s site is working
        As a visitor
        I want navigate properly

    Scenario: Find a baby shoe
        Given I am on "/"
        When I follow "Infantil"
        And I follow "Baby"
        Then I should see "Sandália Klin George Branca"


# Mink com Selenium

Selenium é um automatizador de browser a fim de testar aplicações web.

Com o selenium é possivel testar e utilizar Javascript e todo o conceito de Rich UI.

Download Selenium

    http://selenium.googlecode.com/files/selenium-server-standalone-2.37.0.jar

Inicie o server.

    java -jar selenium-server-standalone-2.37.0.jar


# Mink com Selenium - Feature e cenários

Feature e cenário para aplicação usando mink + selenium:

    Feature: Navigation on Dafiti
        In order to ensure dafiti s site navigation is working
        As a visitor
        I want to go to map site and go to sections

    @javascript
    Scenario: View sitemap
        Given I am on "/"
        When I follow "Mapa do site"
        Then I should see "Calçados Teens"


# Behat - Além ...

# behat.yml

Com o arquivo yml é possivel configurar:

- Profiles: Default e outros...

- Diferentes arquivos Context para profiles

- Paths para Features e Bootstrap

- Filters por tags

- Formatos de respostas (pretty, junit, html)

- Color style no Output


# Behat - Novas Definições na feature

Podemos criar novas definições no seu arquivo de Context.

    Feature: Cart on Dafiti
        In order to ensure dafiti s site access to cart is working
        As a visitor
        I want to choose products add and view cart

    @javascript
    Scenario: Find a man s shoe and add to cart
        Given I am on "/calcados"
        When I follow xpath "//*[@data-src='http://static.dafity.com.br/p/Puma-T%C3%AAnis-Puma-Axis-2-Branco-8952-4729531-sprite.jpg']"
        And I follow xpath "//*[@id='PU493SCM25ITU-58']"
        And I press "Adicionar ao Carrinho"
        Then I should see "Tênis Puma Axis 2 Branco"


# Behat - Novas Definições no context

Para atender a nova definição devemos criar um novo método no Context para suportá-lo.

Usando, neste caso, a API do Mink para essa manipulação.

    /**
     * @When /^I follow xpath "([^"]*)"$/
     */
    public function iClickOnElementWithXPath($xpath)
    {
        $element = $this->getSession()->getPage()->find('xpath',
            $this->getSession()->getSelectorsHandler()
                               ->selectorToXpath('xpath', $xpath));
        if (null === $element) {
            throw new InvalidArgumentException('Could not find XPath');
        }
        $element->click();
    }


# Background scenario

Tipo de cenário utilizado para adicionar ao contexto diversas etapas pré-definidas
para todos os cenários da feature.

Executado antes do cenário a ser processado.

    Background:
        Given I am on ...
        And fill in ... with ...


# Scenario Outline

Este tipo de cenário, possibilita o fluxo ser executado diversas vezes
utilizando placeholders.

    Scenario Outline:
        Given I am on "/"
        When I follow "Mapa do site"
        Then I should see <link>

    Examples:
        |link               |
        |Calçados Masculinos|
        |Calçados Femininos |
        |Calçados Infantis  |


# Tables

Tabelas são usadas para multiplos dados no fluxo do cenário:

    Scenario: Creating Users
        Given the following users:
          | name          | followers |
          | everzet       | 147       |
          | avalanche123  | 142       |

Os dados são enviados para o método relacionado através do objeto TableNode:

    public function pushUsers(TableNode $usersTable)
    {
        $users = array();
        foreach ($usersTable->getHash() as $userHash) {}
    }


# Hooks

Dispara a execução de processos em determinadas etapas do fluxo do behat:

Possuem <strong>Before</strong> e <strong>After</strong> em :
<strong>Suite</strong>, <strong>Feature</strong>, <strong>Scenario</strong>

Esses processos também podem ser <strong>@taggeados</strong>.

    /**
     * @BeforeSuite @database,@orm
     */

    /**
     * @AfterFeature
     */

    /**
     * @BeforeScenario
     */


# pyString

Objeto usado para armazenar retornos com multiplas linhas.

    Scenario Outline:
        Given I am on "/"
        When I follow "..."
        Then I should get:
            """
            Line 1 of returned content
            Line 2 of returned content
            ...

            """


# Relatorio de Resultado

É possível executar o behat gerando um output em HTML:

    behat --format html --out report.html

Também podemos usar o formato junit, para uso, por exemplo, no jenkins:

    behat --format junit --out behat.xml

# Evidências

O driver Selenium2Driver possibilita screenshot da tela que se esta navegando.

Definindo uma ação no fluxo:

    # feature file
    Then I take a screeenshot

Pode-se criar um método na feature para executa-la:

    # FeatureContext.php
    public function getScreenshot()
    {
        $screenshot = $this->getSession()->getDriver()->getScreenshot();
        $date     = new DateTime;
        $filename = $date->format('Ymd-His') . '.png';
        file_put_contents('/../screenshot/'. $filename, $screenshot);
    }



# Referências

Behat documentação, apresentação e video por Konstantin Kudryashov.

[Docs](http://docs.behat.org)

[Slideshow](https://speakerdeck.com/everzet/behat-by-example)

[Presentation](http://www.youtube.com/watch?v=QnPmbQbsTV0)
