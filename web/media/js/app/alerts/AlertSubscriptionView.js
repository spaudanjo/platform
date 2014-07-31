define(['marionette', 'underscore', 'hbs!alerts/AlertSubscription'],

	function(Marionette, _, template){
		return Marionette.ItemView.extend({
			tagName: 'div', 
			template: template, 
			// 	return {
			// 		alertSubscription: {name: "Test alert subscription 1"}
			// 	};
			// }
		});
	}
);