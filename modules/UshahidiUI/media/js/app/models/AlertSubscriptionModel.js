/**
 * Message Model
 *
 * @module     MessageModel
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['backbone', 'modules/config', 'backbone-model-factory'],
	function(Backbone, config) {
		var AlertSubscriptionModel = Backbone.ModelFactory(
		{
			urlRoot: config.get('apiurl') + '/alerts/subscriptions',
			toString : function ()
			{
				return this.get('name');
			}
		});

		return AlertSubscriptionModel;
	});
