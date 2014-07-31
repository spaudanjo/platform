/**
 * Message Collection
 *
 * @module     MessageCollection
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['underscore', 'backbone', 'models/MessageModel', 'modules/config', 'backbone.paginator', 'mixin/FilteredCollection'],
	function(_, Backbone, AlertSubscriptionModel, config, PageableCollection, FilteredCollection)
	{
		// Creates a new Backbone Collection class object
		var AlertSubscriptionCollection = PageableCollection.extend(
			_.extend(
			{
				model : AlertSubscriptionModel,
			    url: config.get('apiurl') + '/alerts/subscriptions',

				// Set state params for `Backbone.PageableCollection#state`
				state: {
					firstPage: 0,
					currentPage: 0,
					pageSize: 4,
					// Required under server-mode
					totalRecords: 0,
					sortKey: 'created',
					order: 1 // 1 = desc
				},

				sortKeys: {
					created : 'Date/Time created',
					id : 'ID'
				},

				sourceTypes: {
					email : 'Email',
					sms : 'SMS',
					twitter : 'Twitter'
				},

				boxTypes: {
					inbox : 'Inbox',
					outbox : 'Outbox',
					archived : 'Archived'
				}, 

				fetch: function(){
					this.set([
					  {
					  	name: "test1"
					  }, 
					  {
					  	name: "test2"
					  }
				    ]);
					alert("FETCH AlertSubscriptionCollection")
				}
			},

			// Mixins must always be added last!
			FilteredCollection
		));

		return AlertSubscriptionCollection;
	});
