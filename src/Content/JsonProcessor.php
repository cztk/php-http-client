<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient\Content;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Throwable;
use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;
use Ztk\HttpClient\ProcessorInterface;

/**
 * Mainly to illustrate the intended use
 * you can easily send and receive json using the ['json'] option parameter
 * for HttpInterface + $response->toArray()
 * If you need more granular repeated control on some bad behaving API
 * or whatever, go for it.
 */
class JsonProcessor implements ProcessorInterface
{
    // TODO php 8.3
    // public const int DEFAULT_JSON_FLAGS = JSON_THROW_ON_ERROR;
    public const DEFAULT_JSON_FLAGS = JSON_THROW_ON_ERROR;
    private string $identifier = '7bca2449-d5eb-4295-80a7-a346c9b83608';
    private LoggerInterface|null $logger;


    public function getIdentifier(): string
    {
        return $this->identifier;
    }


    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }


    /**
     * @inheritDoc
     */
    public function processRequest(Request &$request, array &$options = []): bool
    {
        return true;
    }


    /**
     * for the control fascinados who do not use toArray
     * @inheritDoc
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public function processResponse(Response &$response, array $opts = []): array
    {
        $result = ['processed' => false, 'error' => null];

        try {
            $content = $response->content;


            $json_res = JsonProcessor::jsonDecode($content);
            $result['error'] = $json_res['error'];

            if (!empty($json_res['error'])) {
                // TODO not all responses are in json format
                // TODO some jsons just needs their encoding fixed
                // TODO some jsons are partial json partial some error messages
                $response->extra[$this->identifier] = $json_res['json_array'];

                return $result;
            }

            $result['processed'] = true;
            $result['content'] = $json_res['json_array'];
        } catch (
        ClientExceptionInterface|RedirectionExceptionInterface|
        ServerExceptionInterface $exception
        ) {
            $result['error'][] = $exception->getMessage();
            $this->logger?->log(LOG_CRIT, 'HttpClientException ' . $exception->getMessage());
        }

        return $result;
    }


    /**
     * basically passing things to json_decode
     * default json flag enables exception throwing, which is put into result ['error']
     * if ['error'] is empty and ['result'] true, expect some arrays in ['json']
     * @param string $json_string
     * @param bool|null $associative
     * @param int $depth
     * @param int|null $json_flags
     * @return array
     */
    public static function jsonDecode(string $json_string, bool|null $associative = true, int $depth = 512, int|null $json_flags = null): array
    {
        $result = ['error' => [], 'json_array' => []];

        if (null === $json_flags) {
            $json_flags = self::DEFAULT_JSON_FLAGS;
        }

        try {
            $json_array = json_decode($json_string, $associative, $depth, $json_flags);
            // $result['error'][] = json_last_error_msg();
            $result['json_array'] = $json_array;
        } catch (Throwable $exception) {
            // json_decode works for $json_string = '2', so this must be something else
            $result['error'][] = $exception->getMessage();
        }

        return $result;
    }


    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
