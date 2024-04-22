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
class BindToOption implements OptionInterface
{
    public string $bindTo;


    /**
     * @param string $bind_to the interface or the local socket to bind to
     */
    public function __construct(string $bind_to)
    {
        $this->bindTo = $bind_to;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return ['bindto' => $this->bindTo];
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
