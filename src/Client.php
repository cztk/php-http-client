<?php
/**
 * SPDX-FileCopyrightText: © 2024 Christoph Zysik support@ztk.me
 * SPDX-License-Identifier: BSD-3-Clause
 */

declare(strict_types=1);

namespace Ztk\HttpClient;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;
use Ztk\HttpClient\Model\Request;
use Ztk\HttpClient\Model\Response;

/**
 *
 */
class Client
{
    /**
     * used to call IspConfig remote json API
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;
    /**
     *
     * @var null|LoggerInterface
     */
    private null|LoggerInterface $logger = null;
    /**
     * @var OptionInterface[]
     */
    private array $option = [];
    /**
     * @var ProcessorInterface[]
     */
    private array $processor = [];


    /**
     * @return LoggerInterface|null
     */
    public function &getLogger(): LoggerInterface|null
    {
        return $this->logger;
    }


    /**
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }


    /**
     * @return OptionInterface[]
     */
    public function &getOption(): array
    {
        return $this->option;
    }


    /**
     * @return ProcessorInterface[]
     */
    public function &getProcessor(): array
    {
        return $this->processor;
    }


    /**
     * // TODO awwwww
     * // TODO cache those getOptions as promised, maybe, one day, not here though
     * @param Request $request
     * @param array $opt
     * @return bool
     */
    private function hookRequest(Request &$request, array &$opt = []): bool
    {
        $result = true;
        if (!empty($this->option)) {

            foreach ($this->option as $option) {
                $request->options = array_merge($request->options, $option->getOptions());
            }

            foreach ($this->option as $option) {

                if (!$option->processRequest($request, $opt)) {
                    $result = false;
                }
            }
        }
        if (!empty($this->processor)) {
            foreach ($this->processor as $processor) {
                if (!$processor->processRequest($request, $opt)) {
                    $result = false;
                }
            }
        }
        return $result;
    }


    /**
     * // TODO this is silly
     * @param Response $response
     * @param array $opts
     * @return bool
     */
    private function hookResponse(Response &$response, array $opts = []): bool
    {
        $result = true;
        if (empty($this->option)) {

            foreach ($this->option as $option) {
                if (!$option->processResponse($response, $opts)) {
                    $result = false;
                }
            }
        }
        if (!empty($this->processor)) {
            foreach ($this->processor as $processor) {
                if (!$processor->processResponse($response, $opts)) {
                    $result = false;
                }
            }
        }
        return $result;
    }


    /**
     * @param int $level
     * @param string $message
     * @param array $context
     * @param int $code
     * @param Throwable|null $previous
     * @return Throwable|null
     * @noinspection PhpSameParameterValueInspection
     * @noinspection PhpReturnValueOfMethodIsNeverUsedInspection
     */
    private function log(
        int            $level,
        string         $message,
        array          $context = [],
        int            $code = 1,
        Throwable|null $previous = null
    ): Throwable|null
    {
        $logger = $this->getLogger();
        $logger?->log($level, $message, $context);

        return new Exception('[' . $level . '] ' . $message, $code, $previous);
    }


    /**
     * @param Request $request
     * @param array $processor_data
     * @return Response|null
     */
    public function request(Request $request, array $processor_data = []): Response|null
    {

        $hook_result = $this->hookRequest($request, $processor_data);
        if (!$hook_result) {
            return null;
        }

        try {

            $client_response = $this->httpClient->request($request->method, $request->url, $request->options);

        } catch (TransportExceptionInterface $exception) {

            $this->log(LOG_CRIT, 'HttpClientException ' . $exception->getMessage(), [], 1, $exception);
            return null;

        }
        try {

            $response = new Response($client_response);
            $response->request = $request;

        } catch (
        TransportExceptionInterface|
        ClientExceptionInterface|
        ServerExceptionInterface|
        RedirectionExceptionInterface $exception
        ) {

            $this->log(LOG_CRIT, 'HttpClientException ' . $exception->getMessage(), [], 1, $exception);
            return null;
        }

        $hook_result = $this->hookResponse($response, $processor_data);

        if (!$hook_result) {
            return null;
        }

        return $response;

    }


    /**
     * // TODO setup my own or use the one given
     */
    public function useHttpClient(HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;

    }


    /**
     * @param OptionInterface $option
     * @return void
     */
    public function useOption(OptionInterface $option): void
    {
        $this->option[] = $option;
    }


    /**
     * @param ProcessorInterface $processor
     * @return void
     */
    public function useProcessor(ProcessorInterface $processor): void
    {
        $this->processor[] = $processor;
    }
}
