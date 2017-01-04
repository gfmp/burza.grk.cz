<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use Nette\Utils\DateTime;

/**
 * Message
 *
 * @property int $id {primary}
 * @property string   $message
 * @property User     $user                     {m:1 User::$messages}
 * @property Book     $book                     {m:1 Book::$messages}
 * @property DateTime $createdAt                {default now}
 */
final class Message extends AbstractEntity
{

}
