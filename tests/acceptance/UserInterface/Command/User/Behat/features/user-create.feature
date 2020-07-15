Feature: Users

  Scenario: Execute command with all existing users
    Given a user name "miquel"
    When execute the command
    Then should response with message
      """
      name: miquel
      """
