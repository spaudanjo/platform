/**
 * Settings Application
 *
 * @module     SettingsApp
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['App', 'marionette', 'modules/config'
	],
	function(App, Marionette, config)
	{
		var AlertsAPI = {
			/**
			 * Show alert subscriptions
			 */
			showAlertSubscriptions : function()
			{
				App.vent.trigger('page:change', 'alerts');
				// alert("ALERT");
				// App.layout.mainRegion.show(new AlertSubscriptionListView());
			}
		};

		App.addInitializer(function(){
			new Marionette.AppRouter({
				appRoutes: {
					'alerts' : 'showAlertSubscriptions'
				},
				controller: AlertsAPI
			});
		});
	});
