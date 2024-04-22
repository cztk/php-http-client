<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient\Model;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * represents all response information
 * for HTTPInterface responses + the request we sent
 */
class Response
{
    public string|null $content;

    /**
     * if a processor wants to add $extra['json'] = array
     * fine
     * @var array
     */
    public array $extra = [];

    public array|null $headers;

    public array|null $info = [];

    public Request|null $request;
    public int|null $statusCode;


    /**
     * @param ResponseInterface|null $response
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function __construct(ResponseInterface|null $response)
    {
        $this->headers = $response->getHeaders() ?? null;
        $this->info = $response->getInfo() ?? null;
        $this->statusCode = $response->getStatusCode() ?? null;
        $this->content = $response->getContent() ?? null;
    }
}
