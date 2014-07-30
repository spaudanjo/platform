@oauth2Skip
Feature: Testing the AlertSubscriptions API

    @resetFixture
    Scenario: Listing All AlertSubscriptions
        Given that I want to get all "AlertSubscriptions"
        When I request "/alert_subscriptions"
        Then the response is JSON
        And the response has a "count" property
        And the type of the "count" property is "numeric"
        And the "count" property equals "3"
        Then the guzzle status code should be 200