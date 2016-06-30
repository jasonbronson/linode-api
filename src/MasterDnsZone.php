<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Master DNS Zone.
 *
 * @property    string  $soa_email    Start of Authority (SOA) contact email.
 * @property    int     $ttl_sec      Time interval that the resource record may be cached before it should be discarded, in seconds.
 * @property    int     $refresh_sec  Time interval before the DNS Zone should be refreshed, in seconds.
 * @property    int     $retry_sec    Time interval that should elapse before a failed refresh should be retried, in seconds.
 * @property    int     $expire_sec   Time value that specifies the upper limit on the time interval that can elapse before the DNS Zone is no longer authoritative, in seconds.
 */
class MasterDnsZone extends DnsZone
{
    protected $soa_email;
    protected $ttl_sec;
    protected $refresh_sec;
    protected $retry_sec;
    protected $expire_sec;

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraints('soa_email', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('ttl_sec', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('refresh_sec', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('retry_sec', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('expire_sec', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);
    }
}
