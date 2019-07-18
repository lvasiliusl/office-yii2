<?php
namespace common\helpers;
use Yii;

class Gravatar
{
    public static function getGravatarUrl($email, $size) {
        $hash = md5( strtolower( trim( $email ) ) );
        $rating = 'x';
        // $size = '500';
        return "http://www.gravatar.com/avatar.php?gravatar_id=".$hash.
        "&amp;rating=".$rating."&amp;size=".$size;
    }
}
