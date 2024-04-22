<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

namespace Ztk\HttpClient;

use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;

/**
 * indeed one can also use scoped client
 */
interface OptionInterface
{
    /**
     * if the request data needs to be manipulated e.G. crypto
     * the request options can be manipulated as well.
     * $options parameter can be used to provide any custom data
     * @param Request $request
     * @param array $options
     * @return bool
     */
    public function processRequest(Request &$request, array $options = []): bool;

    /**
     * similar to applyToRequest but for the response
     * @param Response $response
     * @param array $options
     * @return bool
     */
    public function processResponse(Response &$response, array $options = []): bool;

    /**
     * expected to return options to add to the 3rd param of HttpClientInterface
     * Those will be ached and reused
     * $options parameter can be used to provide any custom data
     * @param array $options placeholder for something
     * @return array
     */
    public function getOptions(array $options = []): array;
}
