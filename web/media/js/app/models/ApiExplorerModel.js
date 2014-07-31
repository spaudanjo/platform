/**
 * ApiExplorer Model
 *
 * @module     ApiExplorerModel
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

 define(['backbone'],
 	function(Backbone)
 	{
 		return _.extend(Backbone.Model, {
 			sampleData: {
 				alertSubscriptions: {
 					post: {
 						// {  
 							"locale":"en_us",
 							"status":"draft",
 							"form":"1",
 							"title":"TestPost1",
 							"content":"Some description text",
 							"tags":[  
 							"1"
 							],
 							"user":"",
 							"values":{  
 								"test_varchar":"",
 								"test_point":{  
 									"label":"londong",
 									"lat":51.4433263,
 									"lon":6.5731297
 								},
 								"full_name":"",
 								"description":"",
 								"date_of_birth":"2014-07-30T22:00:00.000Z",
 								"missing_date":"2014-07-30T22:00:00.000Z",
 								"last_location":"london",
 								"last_location_point":[  
 								{  
 									"id":"",
 									"value":{  
 										"label":"",
 										"lat":-36.85,
 										"lon":174.78
 									}
 								}
 								],
 								"geometry_test":"",
 								"missing_status":[  
 								{  
 									"id":"",
 									"value":"information_sought"
 								}
 								],
 								"links":[  
 								{  
 									"id":"",
 									"value":""
 								}
 								],
 								"second_point":{  
 									"label":"",
 									"lat":-36.85,
 									"lon":174.78
 								}
 							}
 						// }
 					}
 				}
 			}
 		});
});
