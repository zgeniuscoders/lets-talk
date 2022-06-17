<?php


namespace Legacy\Legacy;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Legacy\Legacy\Middlewares\MiddlewareException;

class App implements RequestHandlerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private array $controllers;

    /**
     * @var array
     */
    private array $middlewares;

    /**
     * @var int
     */
    private int $index = 0;


    /**
     * App constructor.
     * @param string $configPath
     */
    public function __construct(private string $configPath)
    {
    }

    /**
     * @param string $controller
     * @return $this
     */
    public function addController(string $controller): self
    {
        $this->controllers[] = $controller;
        return $this;
    }

    /**
     * @param string $middleware
     * @return $this
     */
    public function addMiddleware(string $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function getContainer(): ContainerInterface
    {

        if ($this->container === null) {
            $builder = new \DI\ContainerBuilder();

//            if(getenv('APP_ENV') != 'dev')
//            {
//                $builder->enableDefinitionCache([new FilesystemCache('temp/di')]);
//                $builder->writeProxiesToFile(true,'temp/proxies');
//            }

            $builder->useAutowiring(true);
            $builder->addDefinitions($this->configPath);
            $this->container = $builder->build();
        }

        return $this->container;
    }

    /**
     * @return object|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getMiddlewares(): ?object
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->container->get($this->middlewares[$this->index]);
            $this->index++;
            return $middleware;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws MiddlewareException
     * @throws NotFoundExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddlewares();
        if (is_null($middleware)) {
            throw new MiddlewareException("Aucun middleware n'a géré cette request");
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
    }

    /**
     * run
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws MiddlewareException
     * @throws NotFoundExceptionInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {

        foreach ($this->controllers as $controller) {
            $this->getContainer()->get($controller);
        }

        return $this->handle($request);
    }
}
