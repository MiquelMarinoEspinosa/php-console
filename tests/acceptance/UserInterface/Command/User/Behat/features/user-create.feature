Feature: All Sources Video Importer Feature

  Scenario: Execute command with all existing sources
    Given a user name "miquel"
    When execute the command
    Then should response with message
      """
      name: miquel
      """
