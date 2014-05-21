<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_OAuth extends Koauth_Controller_OAuth {

	/**
	 * @var  View  page template
	 */
	public $template = 'template';

	/**
	 * @var  View  page layout template
	 */
	public $layout = 'layout';

	/**
	 * @var  View  page header template
	 */
	public $header = 'header';

	/**
	 * @var  View  page footer template
	 */
	public $footer = 'footer';

	/**
	 * Authorize Requests
	 */
	public function action_get_authorize()
	{
		$auth = A1::instance();
		if (! $auth->logged_in())
		{
			// It is not possible to be authorized without being logged in
			$this->redirect('user/login' . URL::query(array('from_url' => 'oauth/authorize'. URL::query()), FALSE));
		}

		// Load the content template
		$this->template = $view = View::factory('oauth/authorize')
			->set('scopes', explode(' ', $this->request->query('scope')))
			->set('client_id', $this->request->query('client_id'))
			;

		// Load the header/footer/layout
		$this->header = View::factory($this->header);
		$this->header->set('logged_in', $auth->logged_in());
		$this->footer = View::factory($this->footer);
		$this->layout = View::factory($this->layout)
			->bind('content', $this->template)
			->bind('header', $this->header)
			->bind('footer', $this->footer);

		$this->response->body($this->layout->render());
	}

	/**
	 * Authorize Requests
	 */
	public function action_post_authorize()
	{
		$auth = A1::instance();
		if (! $auth->logged_in())
		{
			// It is not possible to be authorized without being logged in
			$this->redirect('user/login' . URL::query(array('from_url' => 'oauth/authorize'. URL::query()), FALSE));
		}

		// todo: try/catch for invalid client, scope, or redirect URI
		$server = service('oauth.server.auth');
		$params = $server->getGrantType('authorization_code')->checkAuthoriseParams();

		if (!$this->request->post('authorize'))
		{
			// todo: this needs to be injected, but it's static. X(
			$this->redirect(
				League\OAuth2\Server\Util\RedirectUri::make($params['redirect_uri'], array(
					'error'         => 'access_denied',
					'error_message' => $server->getExceptionMessage('access_denied'),
					'state'         => Arr::get($params, 'state'),
					))
				);
		}

		// The initial request does not have the user id, we inject it now
		$params['user_id'] = $auth->get_user()->id;

		$code = $server->getGrantType('authorization_code')->newAuthoriseRequest('user', $params['user_id'], $params);

		// Redirect the user back to the client with an authorization code
		$this->redirect(
			// todo: this needs to be injected, but it's static. X(
			League\OAuth2\Server\Util\RedirectUri::make($params['redirect_uri'], array(
					'code'  => $code,
					'state' => Arr::get($params, 'state'),
				))
			);
	}

	/**
	 * Token Requests
	 */
	public function action_post_token()
	{
		$server = service('oauth.server.auth');

		try
		{
			$response = $server->issueAccessToken();
		}
		catch (League\OAuth2\Server\Exception\ClientException $e)
		{

			// Throw an exception because there was a problem with the client's request
			$response = array(
				'error' =>  $server::getExceptionType($e->getCode()),
				'error_description' => $e->getMessage()
			);
			$this->response->headers($server::getExceptionHttpHeaders($server::getExceptionType($e->getCode())));
		}
		catch (Exception $e)
		{
			// Throw an error when a non-library specific exception has been thrown
			$response = array(
				'error' =>  'undefined_error',
				'error_description' => $e->getMessage()
			);
		}
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($response));
	}
}
