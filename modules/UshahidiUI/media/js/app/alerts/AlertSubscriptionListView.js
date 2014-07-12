define(['marionette', 'underscore', 'hbs!alerts/AlertSubscriptionList'],

	function(Marionette, _, template){
		return Marionette.ItemView.extend({
			tagName: 'div', 
			template: template, 
			serializeData: function(){
				return {
					alertSubscription: {name: "Test alert subscription 1"}
				};
			}
		});
	}
);