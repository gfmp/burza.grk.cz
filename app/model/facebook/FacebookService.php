<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Facebook;

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;
use Nette\Http\Session;

final class FacebookService
{

    /** @var Session */
    private $session;

    /** @var string */
    private $appId;

    /** @var string */
    private $appSecret;

    /**
     * @param Session $session
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct(Session $session, $appId, $appSecret)
    {
        $this->session = $session;
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
        $this->session->start();
        return new FacebookRedirectLoginHelper($redirectUrl, $this->appId, $this->appSecret);
    }

}
