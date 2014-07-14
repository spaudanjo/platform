define(['marionette', 'underscore', 'hbs!alerts/AlertSubscriptionList', 'alerts/AlertSubscriptionView'],

	function(Marionette, _, template, AlertSubscriptionView){
		return Marionette.ItemView.extend({
			tagName: 'div', 
			template: template, 
			itemView: AlertSubscriptionView, 
			onShow: function(){
				debugger;
			}
			// serializeData: function(){
			// 	return {
			// 		alertSubscription: {name: "Test alert subscription 1"}
			// 	};
			// }
		});
	}
);