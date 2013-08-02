<?php
namespace Abishekrsrikaanth\Mailto;

use Abishekrsrikaanth\Mailto\Providers\Mandrill\Mandrill;

class Mailto
{
	public function Mandrill($credentials = array())
	{
		return new Mandrill($credentials);
	}
}