<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Facebook;

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;

final class FacebookService
{

    /** @var string */
    private $appId;

    /** @var string */
    private $appSecret;

    /**
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        FacebookSession::setDefaultApplication($appId, $appSecret);
    }

    /**
     * @param string $redirectUrl
     * @return FacebookRedirectLoginHelper
     */
    public function createLoginHelper($redirectUrl)
    {
        return new FacebookRedirectLoginHelper($redirectUrl, $this->appId, $this->appSecret);
    }

}
