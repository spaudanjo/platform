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

    Scenario: Creating a new AlertSubscription
        Given that I want to make a new "AlertSubscription"
        And that the request "data" is:
            """
            {
                "name":"Test Alert Subscription"
            }
            """
        When I request "/alert_subscriptions"
        Then the response is JSON
        And the response has a "id" property
        And the type of the "id" property is "numeric"
        And the "name" property equals "Test Alert Subscription"
        Then the guzzle status code should be 200