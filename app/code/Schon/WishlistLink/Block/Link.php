<?php
namespace Schon\WishlistLink\Block;

use Magento\Customer\Block\Account\SortLinkInterface;

class Link extends \Magento\Wishlist\Block\Link {

//	public function getText()
//	{
//		return "Override Text";
//	}

	/**
	 * @return \Magento\Framework\Phrase
	 */
	public function getLabel()
	{
		return '';
	}
}