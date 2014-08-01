<?php 

/**
 * Ushahidi Platform Create AlertSubscription Repository
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Usecase\AlertSubscription;

use Ushahidi\Entity\AlertSubscription;
use Ushahidi\Tool\Validator;
use Ushahidi\Exception\ValidatorException;

class Create
{
	private $repo;
	private $valid;

	public function __construct(CreateAlertSubscriptionRepository $repo, Validator $valid)
	{
		$this->repo = $repo;
		$this->valid = $valid;
	}

	public function interact(AlertSubscriptionData $input)
	{
		if(!$this->valid->check($input))
			throw new ValidatorException("Failed to validate alert subscription", $this->valid->errors());

		$this->repo->createAlertSubscription(
			$input->name
		);

		return $this->repo->getCreatedAlertSubscription();
	}
}