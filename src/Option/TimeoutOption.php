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
use Ztk\HttpClient\ProcessorInterface;

/**
 *
 */
class TimeoutOption implements OptionInterface
{
    /**
     * defaults to ini_get('default_socket_timeout')
     * @var float
     */
    public float $idle;

    /**
     * a value lower than or equal to 0 means it is unlimited
     * @var float
     */
    public float $request;


    /**
     * @param float $idle the idle timeout (in seconds)
     * @param float $request max request + response time
     */
    public function __construct(float $idle, float $request = 0)
    {
        $this->idle = $idle;
        $this->request = $request;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return ['timeout' => $this->idle, 'max_duration' => $this->request];
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
