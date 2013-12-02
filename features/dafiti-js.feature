Feature: Cart on Dafiti
    In order to ensure dafiti's site access to cart is working
    As a visitor
    I want to choose products add and view cart

@javascript
Scenario: View sitemap
    Given I am on "/"
    When I follow "Mapa do site"
    Then I should see "Calçados Teens"

@javascript
Scenario: Find a man's shoe and add to cart
    Given I am on "/calcados"
    When I follow xpath "//*[@data-src='http://static.dafity.com.br/p/Puma-T%C3%AAnis-Puma-Axis-2-Branco-8952-4729531-sprite.jpg']"
    And I follow xpath "//*[@id='PU493SCM25ITU-58']"
    And I press "Adicionar ao Carrinho"
    And I log content page
    Then I should see "Tênis Puma Axis 2 Branco"
    And I should take a screenshot
