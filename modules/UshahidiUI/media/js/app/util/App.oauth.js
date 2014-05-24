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
		function getUserToken() {
			var cookie = $.cookie('authtoken'),
				token;
			if (cookie) {
				// Kohana signs cookies using "signature~value" format.
				token = cookie.match(/^.+~(.+)$/);
				if (token && token[1]) {
					ddt.log('OAuth', 'got user token', token[1]);
					return token[1];
				}
			}
		}

		function getAnonymousToken(callback)
		{
			var token_params = {
					client_id: window.config.oauth.client,
					client_secret: window.config.oauth.client_secret,
					redirect_uri: window.config.baseurl,
					scope: required_scopes.join(' '),
					grant_type: 'client_credentials'
				};

			if (!anonymous_token_request) {
				anonymous_token_request = $.ajax({
					url: window.config.baseurl + 'oauth/token',
					type: 'POST',
					data: token_params,
					dataType: 'json',
					success: function(data) {
						ddt.log('OAuth', 'got anonymous token', data.access_token);
					}
				});
			} else {
				ddt.log('OAuth', 'still fetching anonymous token');
			}

			return anonymous_token_request.done(function(data)
			{
				anonymous_token = data.access_token;
				callback.call(this, anonymous_token);
			});
		}

		var anonymous_token,
			anonymous_token_request,
			user_token = getUserToken(),
			required_scopes = ['posts', 'media', 'forms', 'api', 'tags', 'sets', 'users'],
			all_scopes = required_scopes.concat(['config', 'messages']),
			UshahidiAuth = {
				initialize : function()
				{
					_.bindAll(this, 'getAuthCodeParams', 'getToken', 'ajax');

					// Use authenticated AJAX calls
					Backbone.ajax = this.ajax;
				},
				getAuthCodeParams : function() {
					return {
						response_type: 'code',
						client_id: window.config.oauth.client,
						redirect_uri: window.config.baseurl + 'user/oauth',
						scope: all_scopes.join(' ')
					};
				},
				getClientType : function()
				{
					return user_token ? 'user' : 'anonymous';
				},
				getToken: function(callback)
				{
					var defer = $.Deferred();
					if (user_token) {
						defer.resolve(user_token);
					}
					else if (anonymous_token) {
						defer.resolve(anonymous_token);
					}
					else {
						getAnonymousToken(function(token) {
							defer.resolve(token);
						})
						.fail(function() {
							defer.reject();
						});
					}
					defer.always(callback);
					return defer.promise();
				},
				ajax: function(settings)
				{
					return this.getToken(function(token) {
						if (!token) {
							throw 'Failed to get OAuth token, unable to make authenticated ajax call';
						}
						if (!settings) {
							settings = {};
						}
						if (!settings.headers) {
							settings.headers = {};
						}
						settings.headers.Authorization = 'Bearer ' + token;
						ddt.log('OAuth', 'making AJAX request', settings.headers);
						return $.ajax(settings);
					});
				}
			};

		UshahidiAuth.initialize();

		return UshahidiAuth;
	});
