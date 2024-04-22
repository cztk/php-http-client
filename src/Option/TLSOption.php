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
use Ztk\HttpClient\ProcessorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Configure TLS options
 */
class TLSOption implements OptionInterface
{
    /**
     * Location of Certificate Authority file on local filesystem
     * which should be used with the verifyPeer context option to authenticate the identity of the remote peer.
     * @var string|null
     */
    private string|null $caFile = null;
    /**
     * If cafile is not specified or if the certificate is not found there,
     * the directory pointed to by capath is searched for a suitable certificate.
     * capath must be a correctly hashed certificate directory.
     * @var string|null
     */
    private string|null $caPath = null;
    /**
     * Sets the list of available ciphers.
     * The format of the string is described in
     * https://www.openssl.org/docs/manmaster/man1/ciphers.html#CIPHER-LIST-FORMAT
     * Defaults to DEFAULT
     * @var string|null
     */
    private string|null $ciphers = null;
    /**
     * e.G: STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT
     * https://www.php.net/manual/en/function.stream-socket-enable-crypto.php
     * @var int|null
     */
    private int|null $cryptoMethod = null;
    /**
     * Path to local certificate file on filesystem.
     * It must be a PEM encoded file which contains your certificate and private key.
     * It can optionally contain the certificate chain of issuers.
     * The private key also may be contained in a separate file specified by localPk.
     * @var string|null
     */
    private string|null $localCert = null;

    /**
     * Path to local private key file on filesystem
     * in case of separate files for certificate (localCert) and private key
     * @var string|null
     */
    private string|null $localPk = null;

    /**
     * Passphrase with which your localCert file was encoded.
     * @var string|null
     */
    private string|null $passphrase = null;
    /**
     * Aborts when the remote certificate digest doesn't match the specified hash.
     * When a string is used, the length will determine which hashing algorithm is applied,
     * either "md5" (32) or "sha1" (40).
     * When an array is used,
     * the keys indicate the hashing algorithm name and each corresponding value is the expected digest
     * @var array|string|null
     */
    private array|string|null $peerFingerprint = null;
    /**
     * orig: capture_peer_cert_chain
     * If set to true a peer_certificate_chain context option will be created containing the certificate chain.
     * @var bool
     */
    private bool $savePeerChain = false;
    /**
     * @var bool
     */
    private bool $verifyHost = true;
    /**
     * Require verification of SSL certificate used.
     * @var bool
     */
    private bool $verifyPeer = true;


    /**
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $opt_name => $value) {
            if (property_exists($this, $opt_name)) {
                $this->{$opt_name} = $value;
            }
        }
    }


    /**
     * @inheritDoc
     */
    public function getOptions(array $options = []): array
    {
        return [
            'verify_peer' => $this->verifyPeer,
            'verify_host' => $this->verifyHost,
            'cafile' => $this->caFile ?? null,
            'capath' => $this->caPath ?? null,
            'local_cert' => $this->localCert ?? null,
            'local_pk' => $this->localPk ?? null,
            'passphrase' => $this->passphrase ?? null,
            'ciphers' => $this->ciphers ?? HttpClientInterface::OPTIONS_DEFAULTS['ciphers'],
            'peer_fingerprint' => $this->peerFingerprint ?? null,
            'capture_peer_cert_chain' => $this->savePeerChain,
            'crypto_method' => $this->cryptoMethod ?? HttpClientInterface::OPTIONS_DEFAULTS['crypto_method'],
        ];
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
