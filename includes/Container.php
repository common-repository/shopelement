<?php

namespace StorePlugin\ShopElement;

use StorePlugin\ShopElement\Container\Dice;
use StorePlugin\ShopElement\Abstracts\Autowire;

/**
 * The file that defines the main start class.
 *
 * @package StorePlugin\ShopElement
 */
class Container extends Autowire
{
	/**
	 * Create DI container object with Dice
	 *
	 * @param Dice $container
	 * @return Autowire
	 */
    public function container( Dice $container ): Autowire
	{
		$this->container = $container;
		return $this;
	}

}
