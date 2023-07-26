<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private UserRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryBody = $request->getParsedBody();
        $email = filter_var($queryBody['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($queryBody['password']);
        $result = $this->repository->passwordVerify($email, $password);

        if (!$result) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        $_SESSION['logado'] = true;
        return new Response(302, ['Location' => '/']);
    }
}