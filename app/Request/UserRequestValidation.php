<?php

namespace App\Request;

use App\Model\User;
use GuzzleHttp\Psr7\ServerRequest;
use Valitron\Validator;
use Zgeniuscoders\Zgeniuscoders\Validation\RequestValidator;

class UserRequest
{

    private RequestValidator $request;

    private $user;

    public function __construct(array $data)
    {
         $this->request = new RequestValidator(data: $data, lang: 'fr');
//         $this->user = $user;
    }

     public function rules()
     {
//         $user = $this->user;
         $this->request->rules([
             'required' => ['name', 'pseudo', 'email', 'password'],
             'email' => ['email'],
             'length' => [['password', 6]]
         ]);
//         $this->request->rule(function ($field, $value) use ($user) {
//             return !$user->exists($field, $value);
//         }, ['email']);
     }

     public function validate(): bool
     {
         return $this->request->validate();
     }

     public function errors(): array
     {
         return $this->request->errors();
     }
}
