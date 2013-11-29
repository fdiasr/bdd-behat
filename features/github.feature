Feature: Get repositories from github
    In order to check code on github
    As a developer
    I want to get code from repositories

Scenario: Get DafitiSprint repositories info
    Given I get app to connect to Github
    When I call info for public repositories from "DafitiSprint"
    Then I get "1" repositorie(s)
    And repository name is "dojos"
