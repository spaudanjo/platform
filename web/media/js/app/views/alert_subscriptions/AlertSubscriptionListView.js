/**
 * Alert Subscription List View
 *
 * @module     UserListView
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['App', 'marionette', 'underscore', 'alertify',
		'views/alert_subscriptions/AlertSubscriptionListItemView',
		'views/EmptyView',
		'hbs!templates/alert_subscriptions/AlertSubscriptionList'
	],
	function(App, Marionette, _, alertify, 
		AlertSubscriptionItemView, 
		EmptyView, 
		template)
	{
		return Marionette.CompositeView.extend({
			template: template, 
			modelName: 'alert_subscriptions', 

			initialize: function()
			{
				//TODO: Bind select/unselect events from itemviews
			},

			itemView: AlertSubscriptionItemView, 

			itemViewContainer: '.list-view-alert-subscription-list', 

			itemViewOptions: 
			{
				emptyMessage: 'No alert subscriptions found'
			}, 

			emptyView: EmptyView, 

			events: {

			}, 

			serializeData: function()
			{
				var data = { items: this.collection.toJSON()};

				// TODO: add extra data for pagination etc here

				return data;
			}
		});
	}
);