<?php

/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

use Ztk\HttpClient\Content\JsonProcessor;
use Ztk\HttpClient\Model\Request;

require 'vendor/autoload.php';

$logger = new Monolog\Logger('logger');

$haproxy_protocol_would_be_nice = new Ztk\HttpClient\Option\ResolveOption(['example.com' => '127.0.0.1']);
$json_processor = new JsonProcessor();
$json_processor->setLogger($logger);

$http_client = new Ztk\HttpClient\Client();
$http_client->setLogger($logger);
$http_client->useHttpClient(new Symfony\Component\HttpClient\CurlHttpClient());
$http_client->useOption($haproxy_protocol_would_be_nice);
$http_client->useProcessor($json_processor);

/** @noinspection HttpUrlsUsage */
$request = new Request('GET', 'http://example.com');

$response = $http_client->request($request);

print_r($response);
