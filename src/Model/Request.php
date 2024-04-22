<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient\Model;

/**
 * represents all request information
 * for HTTPInterface requests
 */
class Request
{

    public string|null $method;
    public array $options = [];
    public string|null $url;


    public function __construct(string $method = null, string $url = null, array $options = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->options = $options;
    }
}