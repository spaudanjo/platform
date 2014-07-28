<?php 

use Ushahidi\Entity\AlertSubscription;
use Ushahidi\Entity\AlertSubscriptionRepository;

class Ushahidi_Repository_AlertSubscription extends Ushahidi_Repository 
implements AlertSubscriptionRepository
{
	protected function getTable()
	{
		return 'alert_subscriptions';
	}

	protected function getEntity(Array $data = null)
	{
		return new AlertSubscription($data);
	}

	public function get($id)
	{
		return new AlertSubscription($data);
	}

	public function getAll()
	{
		$query = $this->selectQuery();
		$results = $query->execute($this->db);

		return $this->getCollection($results->as_array());
		// return ["jo1", "jo2"];

	}

}


?>