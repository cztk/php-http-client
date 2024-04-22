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


    /**
     * This shall return the processors identifier set by hooman
     * @see \Ztk\HttpClient\Model\Response::$info where the identifier shall be used to store relevant data
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * set the processors identifier
     * only useful really if the processor adds custom data
     * insteadof overwriting content
     * @param string $identifier
     * @return void
     */
    public function setIdentifier(string $identifier) : void;
}
