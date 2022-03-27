<?php


namespace Zgeniuscoders\Zgeniuscoders\Validation;


class ValidationError
{
    /**
     * @var string
     */
    private string $key;
    /**
     * @var string
     */
    private string $rule;

    private array $messages = [
        'required' => 'Le champs %s est requis',
        'empty' => 'Le champ %s ne peut être vide',
        'slug' => 'Le champ %s n\'est pas un slug valide',
        'minLength' => 'Le champ %s doit contenir plus de %d caractères',
        'maxLength' => 'Le champ %s doit contenir moins de %d caractères',
        'betweenLength' => 'Le champ %s doit contenir entre %d et %d caractères',
        'datetime' => 'Le champ %s doit être une date valide (%s)',
    ];
    private array $attributes;

    /**
     * ValidationError constructor.
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    public function __construct(string $key, string $rule, array $attributes)
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString(): string
    {
        $params = array_merge([$this->messages[$this->rule],$this->key],$this->attributes);
        return (string)call_user_func_array('sprintf',$params);
    }

    /**
     * @return array|string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}