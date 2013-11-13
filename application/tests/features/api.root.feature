@oauth2Skip
Feature: Testing the Root API

    Scenario: Listing API version
        Given that I want to get all "Root"
        When I request "/"
        Then the response is JSON
        And the "version" property is "numeric"
        And the "ushahidi_version" property is "numeric"
        Then the guzzle status code should be 200