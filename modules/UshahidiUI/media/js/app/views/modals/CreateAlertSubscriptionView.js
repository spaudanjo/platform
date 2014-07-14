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
 				alert("init Create Alert subscription view");
 			},
 			events: {
				// 'submit form' : 'formSubmitted',
				// 'click .js-switch-fieldset' : 'switchFieldSet',
				// 'click .js-back-button' : 'goBack'
			},
			onShow: function()
			{
			}
		});
	}
);
