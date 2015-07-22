<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_OAuth
 */

namespace ZendOAuthTest\Signature;

use ZendOAuth\Signature;

/**
 * @category   Zend
 * @package    Zend_OAuth
 * @subpackage UnitTests
 * @group      Zend_OAuth
 */
class PlaintextTest extends \PHPUnit_Framework_TestCase
{

    public function testSignatureWithoutAccessSecretIsOnlyConsumerSecretString()
    {
        $params = array(
            'oauth_version' => '1.0',
            'oauth_consumer_key' => 'dpf43f3p2l4k3l03',
            'oauth_signature_method' => 'PLAINTEXT',
            'oauth_timestamp' => '1191242090',
            'oauth_nonce' => 'hsu94j3884jdopsl',
            'oauth_version' => '1.0'
        );
        $signature = new Signature\Plaintext('1234567890');
        $this->assertEquals('1234567890&', $signature->sign($params));
    }

    public function testSignatureWithAccessSecretIsConsumerAndAccessSecretStringsConcatWithAmp()
    {
        $params = array(
            'oauth_version' => '1.0',
            'oauth_consumer_key' => 'dpf43f3p2l4k3l03',
            'oauth_signature_method' => 'PLAINTEXT',
            'oauth_timestamp' => '1191242090',
            'oauth_nonce' => 'hsu94j3884jdopsl',
            'oauth_version' => '1.0'
        );
        $signature = new Signature\Plaintext('1234567890', '0987654321');
        $this->assertEquals('1234567890&0987654321', $signature->sign($params));
    }

}
