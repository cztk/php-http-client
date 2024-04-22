<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient\Option;

use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;
use Ztk\HttpClient\OptionInterface;

/**
 *
 */
class ResolveOption implements OptionInterface
{
    public array $hostIpMap;


    /**
     * @param array $host_ip_map
     */
    public function __construct(array $host_ip_map)
    {
        $this->hostIpMap = $host_ip_map;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return ['resolve' => $this->hostIpMap];
    }


    /**
     * @inheritDoc
     */
    public function processRequest(Request &$request, array $options = []): bool
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public function processResponse(Response &$response, array $options = []): bool
    {
        return true;
    }
}
