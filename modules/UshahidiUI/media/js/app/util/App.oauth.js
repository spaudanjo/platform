/**
 * Oauth setup
 *
 * @module     App.oauth
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

define(['backbone', 'jso2/jso2', 'jquery', 'underscore'],
	function(Backbone, Jso2, $, _)
	{
		var ushahidi_auth = {
			initialize : function ()
			{
				// this treats the user secret for the ui client as a pubkey
				var anonymous_config = {
						client_id: window.config.oauth.client,
						client_secret: window.config.oauth.client_secret,
						// no authorization required for client_credentials
						token: window.config.baseurl + 'oauth/token',
						redirect_uri: window.config.baseurl,
						scopes: {
							request: ['posts', 'media', 'forms', 'api', 'tags', 'sets', 'users', 'config', 'messages'],
							require: ['posts', 'media', 'forms', 'api', 'tags', 'sets', 'users']
						},
						grant_type: 'client_credentials'
					};

				_.bindAll(this, 'setProvider', 'ajax');

				Jso2.enablejQuery($);

				this.providers = {};
				this.provider = null;

				this.providers.anonymous = new Jso2('ushahidi_anonymous', anonymous_config);
				this.setProvider('anonymous');

				// Override backbone AJAX with our AJAX switcher
				Backbone.ajax = this.ajax;
			},
			/**
			 * Set OAuth Provider
			 * @param {String} provider_name Provider name: anonymous
			 */
			setProvider : function(provider_name)
			{
				var that = this,
					provider = this.provider = this.providers[provider_name];

				// Ensure we have an access token before everything starts
				return provider.getToken(function(token) {
					// If we've got a token here, check if we're logged in etc.
					that.currentToken = token;
				});
			},
			/**
			 * Get authorization headers, ie for an xhr.
			 */
			getAuthHeaders : function () {
				var headers = {};
				if (this.currentToken) {
					headers.Authorization = 'Bearer ' + this.currentToken.access_token;
				}
				return headers;
			},
			/**
			 * Call the appropriate ajax function based on provider
			 */
			ajax : function()
			{
				return this.provider.ajax.apply(this.provider, arguments);
			}
		};

		ushahidi_auth.initialize();

		return ushahidi_auth;
	});
