<?php


namespace Zgeniuscoders\Zgeniuscoders\Middlewares;

use ArrayAccess;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zgeniuscoders\Zgeniuscoders\Middlewares\Exceptions\CSRFException;
use Zgeniuscoders\Zgeniuscoders\Session\SessionInterface;

class CSRFMiddleware implements MiddlewareInterface
{

    /**
     * CSRFMiddleware constructor.
     * @param ArrayAccess|array|SessionInterface $session
     * @param int $limit
     * @param string $formKey
     * @param string $sessionKey
     */
    public function __construct(
        private ArrayAccess|array|SessionInterface &$session,
        private int $limit = 60,
        private string $formKey = '__csrf',
        private string $sessionKey = 'csrf'
    ) {
    }

    /**
     * @throws CSRFException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE'])) {
            $params = $request->getParsedBody() ?: [];
            if (!array_key_exists($this->formKey, $params)) {
                throw new CSRFException();
            } else {
                $csrfList = $this->session[$this->sessionKey] ?? [];
                if (in_array($params[$this->formKey], $csrfList)) {
                    $this->useToken($params[$this->formKey]);
                    return $handler->handle($request);
                } else {
                    throw new CSRFException();
                }
            }
        }
        return $handler->handle($request);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generateToken(): string
    {
        $token = bin2hex(random_bytes(16));
        $csrfList = $this->session[$this->sessionKey] ?? [];
        $csrfList[] = $token;
        $this->session[$this->sessionKey] = $csrfList;
        $this->limitToken();
        return $token;
    }

    private function useToken($token)
    {
        $tokens = array_filter($this->session[$this->sessionKey], function ($t) use ($token) {
            return $token !== $t;
        });
        $this->session[$this->sessionKey] = $tokens;
    }

    /**
     * @return void
     */
    private function limitToken(): void
    {
        $tokens = $this->session[$this->sessionKey] ?? [];
        if (count($tokens) > $this->limit) {
            array_shift($tokens);
        }

        $this->session[$this->sessionKey] =$tokens;
    }

    /**
     * @return string
     */
    public function getFormKey(): string
    {
        return $this->formKey;
    }
}
