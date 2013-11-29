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

* Compreensão da área de negócio em relação ao que está será desenvolvido e entregue


# BDD - Definições

BDD se utiliza da linguaguem ubiqua, e basicamente se estrutura em 3 niveis para definição dos requisitos:

* <strong>Feature</strong> - narrativa da feature (estória)
* <strong>Scenarios</strong> - descrição de um cenário da feature
* <strong>Detalhamento</strong> - detalhes que uma situação de execução do processo

Essas definições de requisitos são utilizadas no <strong>framework</strong> para o desenvolvimento BDD

# O que é Behat ?

- PHP BDD Framework

- Inspirado no Cucumber - Ruby

- Com o behat você descreve suas features (estorias), com os cenarios,
  e cria métodos para definir os Passos a serem executados para isso.


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
    - Quem vai executar processo e ser beneficiado (who)
    - O que é necessário para o fluxo da feature sem realizado (how)

# BDD / Behat - Especificando cenários

Cada feature possui situações e decisões que resultarão em fluxos no processo.

Cada situação e fluxo desses deve ser definido em um cenário para a feature

- Formato Given/When/Then para descrição dos cenários
    - Given: pré-condições para o cenário
    - When: eventos que devem ocorrer para execução do cenário
    - Then: resultados da execução do cenário


# Vamos a prática ...

Colocando a mão na massa...


# Uso básico do Behat

Vamos realizar um teste simples com uma lib do knplabs para conectar a api do github:

<% code do %>
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
    }ma
}
<% end %>


# Iniciando o Behat

<% code do %>
    # command line
    composer install
    behat --init
<% end %>

Após instalar o composer e iniciar o behat, é adicionado à pasta do projeto a seguinte estrutura:

    \features
       \bootstrap
            FeatureContext.php

Agora podemos criar nossas features e seus cenários:

    \features\bootstrap\github.feature


# Behat - Feature

Vamos descrever a nossa feature:

    Feature: Get repositories from github
        In order to check code on github
        As a developer
        I want to get code from repositories


# Behat - Cenário

Agora, vamos escrever um primeiro cenário:

    Scenario: Get DafitiSprint repositories info
        Given I get app to connect to Github
        When I call info for public repositories from "DafitiSprint"
        Then I get "1" repositorie(s)
        And repository name is "dojos"


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

- Mink - Extensão para camada de abstração de browser/http
    - Remove diferenças entre apis dos browsers e emuladores
    - Fácil controle do browser - navegação, sessão, etc...
    - Drives
        - GoutteDriver - Bridge para Goutte (Symfony)
        - Selenium2Driver - Bridge para Selenium webdriver
        - ...


# Behat + Mink na prática

Precimos adicionar as dependencias do Mink:

<% code do %>
# composer.json
    "require": {
        "behat/mink": "1.4@stable",
        "behat/mink-extension": "*",
        "behat/mink-goutte-driver": "*",
        "behat/mink-selenium2-driver": "*"
    },
<% end %>

Vamos criar uma nova feature para os novos testes:

    \features\bootstrap\bdd-wiki.feature

# FeatureContext extendendo Mink

Também vamos extender a classe MinkContext a FeatureContext

<% code do %>
use Behat\MinkExtension\Context\MinkContext;

    class FeatureContext extends MinkContext
    {
    }
<% end %>

Devemos criar o arquivo behat.yml, para definir o autoload das extensões do mink e dos drivers:

<% code do %>
# behat.yml
default:
    extensions:
        Behat\MinkExtension\Extension:
            base_url: http://dafiti.com.br
            goutte: ~
            selenium2: ~
<% end %>


# Feature e Cenários para o Mink

No terminal, podemos visualizar a lista de definições pré definidas do Mink

<% code do %>
behat -dl
<% end %>


# Mink com Goutee

Goutte é um driver que faz uma requisição HTTP e parsea o conteúdo retornado.

Sem Javascript, Ajax, UI.

Feature e cenário para aplicação usando mink + goutee:

<% code do %>
Feature: Navigation on Dafiti
    In order to ensure dafiti's site is working
    As a visitor
    I want navigate properly

Scenario: Find a baby shoe
    Given I am on "/"
    When I follow "Infantil"
    And I follow "Baby"
    And I log content page
    Then I should see "Sandália Klin George Branca"
<% end %>


# Mink com Selenium

Selenium é um automatizador de browser a fim de testar aplicações web.

Com o selenium é possivel testar e utilizar Javascript e todo o conceito de Rich UI.

Download Selenium

<% code do %>
http://selenium.googlecode.com/files/selenium-server-standalone-2.37.0.jar
<% end %>

Inicie o server.

<% code do %>
java -jar selenium-server-standalone-2.37.0.jar
<% end %>


# Mink com Selenium - Feature e cenários

Feature e cenário para aplicação usando mink + selenium:

<% code do %>
Feature: Navigation on Dafiti
    In order to ensure dafiti's site navigation is working
    As a visitor
    I want to go to map site and go to sections

@javascript
Scenario: View sitemap
    Given I am on "/"
    When I follow "Mapa do site"
    Then I should see "Calçados Teens"
<% end %>


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

<% code do %>
Feature: Cart on Dafiti
    In order to ensure dafiti's site access to cart is working
    As a visitor
    I want to choose products add and view cart

@javascript
Scenario: Find a man's shoe and add to cart
    Given I am on "/calcados"
    When I follow xpath "//*[@data-src='http://static.dafity.com.br/p/Puma-T%C3%AAnis-Puma-Axis-2-Branco-8952-4729531-sprite.jpg']"
    And I follow xpath "//*[@id='PU493SCM25ITU-58']"
    And I press "Adicionar ao Carrinho"
    And I log content page
    Then I should see "Tênis Puma Axis 2 Branco"
<% end %>

# Behat - Novas Definições no context

Para atender a nova definição devemos criar um novo método no Context para suportá-lo.

Usando, neste caso, a API do Mink para essa manipulação.

<% code do %>
/**
 * @When /^I follow xpath "([^"]*)"$/
 */
public function iClickOnElementWithXPath($xpath)
{
    $element = $this->getSession()->getPage()->find('xpath',
        $this->getSession()->getSelectorsHandler()
                           ->selectorToXpath('xpath', $xpath));
    if (null === $element) {
        throw new InvalidArgumentException('Could not find XPath");
    }
    $element->click();
}
<% end %>


# Background scenario


# Scenario Outline

# Hooks

Dispara a execução de processos em determinadas etapas do fluxo do behat:

Possuem <strong>Before</strong> e <strong>After</strong> em :
<strong>Suite</strong>, <strong>Feature</strong>, <strong>Scenario</strong>

Esses processos também podem ser <strong>@taggeados</strong>.

<% code do %>

/**
 * @BeforeScenario @database,@orm
 */

<% end %>

# tables

<% code do %>
  Scenario: Creating Users
    Given the following users:
      | name          | followers |
      | everzet       | 147       |
      | avalanche123  | 142       |
      | kriswallsmith | 274       |
      | fabpot        | 962       |
<% end %>


# pyString


# relatorio de resultado


# Referências

Behat docs, presentation and videos by Konstantin Kudryashov

[Docs](http://docs.behat.org)

[Slideshow](https://speakerdeck.com/everzet/behat-by-example)

[Presentation](http://www.youtube.com/watch?v=QnPmbQbsTV0)

<style>

.slide p, .slide li {
    padding: 10px 0;
    font-size: 30px !important;
}

pre  {
    font-size: 20px;
}

</style>