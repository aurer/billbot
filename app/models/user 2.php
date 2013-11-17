<?php

class User extends Eloquent
{
	public function bills()
	{
		return $this->has_many('Bill');
	}
}