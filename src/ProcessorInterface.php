<?php

/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

namespace Ztk\HttpClient;

use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;

/**
 *
 */
interface ProcessorInterface
{
    /**
     * @param Request $request
     * @param array $options
     * @return bool
     */
    public function processRequest(Request &$request, array &$options = []): bool;


    /**
     * @param Response $response
     * @param array $opts
     * @return array
     */
    public function processResponse(Response &$response, array $opts = []): array;
}
