<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient\Option\Auth;

use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;
use Ztk\HttpClient\OptionInterface;
use Ztk\HttpClient\ProcessorInterface;

/**
 *
 */
final class BasicOption implements OptionInterface
{
    private string $password;
    private string $username;


    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return ['auth_basic' => [$this->username, $this->password]];
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
