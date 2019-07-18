<?php
namespace common\models;

use common\models\User;
use yii\db\ActiveRecord;

/**
 * UserMeta model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $meta_key
 * @property string $meta_value
 */
class UserMeta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getMeta($user_id, $key)
    {
        $meta = static::findOne(['user_id' => $user_id, 'meta_name' => $key]);
        $value = null;

        if( $meta && static::is_serialized($meta->meta_value) ) {
            $value = unserialize($meta->meta_value);
        } elseif ( $meta ) {
            $value = $meta->meta_value;
        }

        return $value;
    }

    public function addMeta($user_id, $key, $value=null)
    {

    }

    public function updateMeta($user_id, $key, $value=null)
    {
        // $value = $this->_prepare_meta($value);
        //
        // if( $this->_is_serialized() )
    }

    public function deleteMeta($user_id, $key)
    {

    }

    private function _prepare_meta( $value=null )
    {
        if( is_array($value) ) {
            $value = serialize($value);
        }

        return $value;
    }

    public static function is_serialized( $data, $strict = true ) {
	        // if it isn't a string, it isn't serialized.
	        if ( ! is_string( $data ) ) {
	                return false;
	        }
	        $data = trim( $data );
	        if ( 'N;' == $data ) {
	                return true;
	        }
	        if ( strlen( $data ) < 4 ) {
	                return false;
	        }
	        if ( ':' !== $data[1] ) {
	                return false;
	        }
	        if ( $strict ) {
	                $lastc = substr( $data, -1 );
	                if ( ';' !== $lastc && '}' !== $lastc ) {
	                        return false;
	                }
	        } else {
	                $semicolon = strpos( $data, ';' );
	                $brace     = strpos( $data, '}' );
	                // Either ; or } must exist.
	                if ( false === $semicolon && false === $brace )
	                        return false;
	                // But neither must be in the first X characters.
	                if ( false !== $semicolon && $semicolon < 3 )
	                        return false;
	                if ( false !== $brace && $brace < 4 )
	                        return false;
	        }
	        $token = $data[0];
	        switch ( $token ) {
	                case 's' :
	                        if ( $strict ) {
	                                if ( '"' !== substr( $data, -2, 1 ) ) {
	                                        return false;
	                                }
	                        } elseif ( false === strpos( $data, '"' ) ) {
	                                return false;
	                        }
	                        // or else fall through
	                case 'a' :
	                case 'O' :
	                        return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
	                case 'b' :
	                case 'i' :
	                case 'd' :
	                        $end = $strict ? '$' : '';
	                        return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
	        }
	        return false;
	}

}
