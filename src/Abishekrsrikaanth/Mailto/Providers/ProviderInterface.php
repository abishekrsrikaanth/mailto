<?php
namespace Abishekrsrikaanth\Mailto\Providers;


interface ProviderInterface
{
	public function send($timestamp = null);
	public function sendBatch($timestamp = null);
}