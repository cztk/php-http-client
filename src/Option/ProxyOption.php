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
class ProxyOption implements OptionInterface
{
    public string|null $noProxy;
    public string $proxy;


    /**
     * @param string $proxy
     * @param string|null $no_proxy
     */
    public function __construct(string $proxy, string $no_proxy = null)
    {
        $this->proxy = $proxy;
        $this->noProxy = $no_proxy;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        $result = [];
        if ($this->proxy) {
            $result['proxy'] = $this->proxy;
        }
        if ($this->noProxy) {
            $result['no_proxy'] = $this->noProxy;
        }
        return $result;
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
