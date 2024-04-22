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
class HeadersOption implements OptionInterface
{
    public array $headers;


    /**
     * @param array $headers the interface or the local socket to bind to
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return ['headers' => $this->headers];
    }


    /**
     * @inheritDoc
     */
    public function processRequest(Request &$request, array $options = []): bool
    {
        //$headers = array_merge($this->headers, $request_options['headers'] ?? []);
        //$request_options['headers'] = $headers;
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
