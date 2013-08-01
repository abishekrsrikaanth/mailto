<?php
namespace Abishekrsrikaanth\Mailto\Providers;


interface ProviderInterface
{
	public function send();
	public function batchSend();
}