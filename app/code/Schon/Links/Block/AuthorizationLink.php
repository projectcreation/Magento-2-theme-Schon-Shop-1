<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Schon\Links\Block;

use Magento\Customer\Model\Context;
use Magento\Customer\Block\Account\SortLinkInterface;


class AuthorizationLink extends \Magento\Customer\Block\Account\AuthorizationLink
{

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->isLoggedIn() ? 'o' : 'i' ;
    }

    public function isLoggedIn()
    {
        return $this->httpContext->getValue(Context::CONTEXT_AUTH);
    }

}
