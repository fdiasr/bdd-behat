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

Scenario: View sitemap
    Given I am on "/"
    When I follow "Mapa do site"
    Then I should see "Calçados Teens"
