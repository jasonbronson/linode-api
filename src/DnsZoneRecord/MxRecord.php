<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\DnsZoneRecord;

use Linode\Enum\DnsZoneRecordEnum;
use Linode\LinodeClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * MX-record.
 *
 * @property    string  $mail_server  FQDN of the mail server.
 * @property    string  $subdomain    Optional subdomain to be delegated to the mail server.
 * @property    int     $priority     Priority of the record.
 */
class MxRecord extends DnsZoneRecord
{
    protected $mail_server;
    protected $subdomain;
    protected $priority;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client      Linode API client.
     * @param   string       $dnszone     DNS Zone ID which this record belongs to.
     * @param   string       $mail_server FQDN of the mail server.
     * @param   string       $subdomain   Optional subdomain to be delegated to the mail server.
     * @param   int          $priority    Priority of the record.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $mail_server, $subdomain = null, $priority = 10)
    {
        parent::__construct($client, [
            'type'     => DnsZoneRecordEnum::MX,
            'target'   => $mail_server,
            'name'     => $subdomain,
            'priority' => $priority,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('mail_server', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('subdomain', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('priority', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\Range(['min' => 0, 'max' => 255]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        $properties = parent::getMutableProperties();

        $properties['target']   = $this->mail_server;
        $properties['name']     = $this->subdomain;
        $properties['priority'] = $this->priority;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(array $data = [])
    {
        $properties = [
            'target'   => 'mail_server',
            'name'     => 'subdomain',
            'priority' => 'priority',
        ];

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $data)) {
                $this->$property = $data[$key];
            }
        }

        parent::initialize($data);
    }
}
