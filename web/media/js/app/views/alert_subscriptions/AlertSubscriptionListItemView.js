define(['App', 'marionette', 'alertify', 'hbs!templates/alert_subscriptions/AlertSubscriptionListItem'], 
	function(App, Marionette, alertify, template){
		return Marionette.ItemView.extend(
		{
			template: template, 
			tagName: 'li', 
			className: 'list-view-alert-subscription'
		});
	});