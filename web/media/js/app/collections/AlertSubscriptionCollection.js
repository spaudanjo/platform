/**
 * AlertSubscription Collection
 *
 * @module     AlertSubscriptionCollection
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['backbone', 'underscore', 'modules/config', 'models/AlertSubscriptionModel', 'mixin/ResultsCollection'],
	function(Backbone, _, config, AlertSubscriptionModel, ResultsCollection)
	{
		// Creates a new Backbone Collection class object
		var AlertSubscriptionCollection = Backbone.Collection.extend(
			_.extend(
			{
				model : AlertSubscriptionModel,
				url: config.get('apiurl') +'alert_subscriptions',
			},
			// Mixins must always be added last!
			ResultsCollection
		));

		return AlertSubscriptionCollection;
	});
