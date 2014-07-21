/**
 * Alert subscriptions Application
 *
 * @module     SettingsApp
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['App', 'marionette', 'models/AlertSubscriptionModel', 'collections/AlertSubscriptionCollection', 'alerts/AlertSubscriptionListView'
	],
	function(App, Marionette, AlertSubscriptionModel, AlertSubscriptionCollection, AlertSubscriptionListView)
	{
		var AlertsAPI = {
			/**
			 * Show alert subscriptions
			 */
			showAlertSubscriptions : function()
			{
				App.vent.trigger('page:change', 'alerts');
				// alert("ALERT");
				var subscriptions = new AlertSubscriptionCollection();
				subscriptions.fetch();
				App.layout.mainRegion.show(new AlertSubscriptionListView({
					collection: subscriptions
				}));
			}, 

			newAlertSubscription : function(){
				App.vent.trigger('alert_subscriptions:create');
				// App.layout.mainRegion
				// console.log(newAlertSubscription);
				// alert("NEW ALERT SUBSCRIPTION");

			}
		};

		App.addInitializer(function(){
			new Marionette.AppRouter({
				appRoutes: {
					'alerts/subscriptions' : 'showAlertSubscriptions', 
					// 'alerts/subscriptions/new' : 'newAlertSubscription'
				},
				controller: AlertsAPI
			});
		});
	});