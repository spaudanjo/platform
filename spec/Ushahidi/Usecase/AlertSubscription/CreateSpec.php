<?php 
namespace spec\Ushahidi\Usecase\AlertSubscription;

use Ushahidi\Tool\Validator;
use Ushahidi\Entity\AlertSubscription;
use Ushahidi\Usecase\AlertSubscription\CreateAlertSubscriptionRepository;
use Ushahidi\Usecase\AlertSubscription\AlertSubscriptionData;

use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior 
{
	function let(CreateAlertSubscriptionRepository $repo, Validator $valid)
	{
		$this->beConstructedWith($repo, $valid);
	}

	function it_is_initializable()
	{
		$this->shouldHaveType('Ushahidi\Usecases\AlertSubscription\Create');
	}

	// function it_fails_with_invalid_input


}
