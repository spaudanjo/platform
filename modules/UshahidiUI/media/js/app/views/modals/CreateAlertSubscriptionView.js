/**
 * Create Post
 *
 * @module     CreatePostView
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

 define([ 'App', 'marionette', 'underscore', 'alertify', 'hbs!templates/modals/CreateAlertSubscription',
 	'models/AlertSubscriptionModel',
 	'collections/AlertSubscriptionCollection',
 	'backbone-validation', 'forms/UshahidiForms'],
 	function( App, Marionette, _, alertify, template,
 		AlertSubscriptionModel,
 		AlertSubscriptionCollection,
 		BackboneValidation, BackboneForm)
 	{
 		return Marionette.ItemView.extend( {
 			template: template,
 			initialize : function ()
 			{
 				this.form = new BackboneForm({
 					model: this.model, 
 					idPrefix: "IDEFIX", 
 					className: 'edit-alert-subscription-TESTCLASS'
 				});
 			},

 			events: {
				'submit form' : 'formSubmitted',
				// 'click .js-switch-fieldset' : 'switchFieldSet',
				// 'click .js-back-button' : 'goBack'
			},

			onDomRefresh : function()
			{
				// Render the form and add it to the view
				this.form.render();

				// Set form id, backbone-forms doesn't do it.
				this.form.$el.attr('id', 'edit-alert-subscription-form');

				this.$('.alert-subscription-form-wrapper').append(this.form.el);
			},

			formSubmitted: function(e){
				var that = this; 
				var errors; 
				var request; 

				e.preventDefault();

				errors = this.form.commit({ validate: true });

				if(!errors){
					request = this.model.save();
					if(request){
						request.done(function(){
							alertify.success("Alert subscription was successfully created");
							that.trigger("close");
						}).fail(function(response){
							alertify.error("Unable to save alert subscirption, please try again!")
							if(response.errors)
								console.log(response.errors);
						});
					}
					else
					{
						alertify.error("Unable to save user details, please try again.");
						console.log(this.model.validationError);
					}
				}
			},
			serializeData: function()
			{
				return _.extend(this.model.toJSON(),
					{
						isNew : this.model.isNew()
					}
				);
			}, 
			// serializeData : function(){
			// 	return {name: }
			// }
		});
	}
);
