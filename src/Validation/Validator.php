<?php


namespace Zgeniuscoders\Zgeniuscoders\Validation;

use Psr\Http\Message\UploadedFileInterface;

class Validator
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @var string[]
     */
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Add error
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    private function addErrors(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getValue(string $key): mixed
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * check if the fields are in the array
     * @param string ...$keys
     * @return $this
     */
    public function required(string ...$keys) : self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);

            if (is_null($value)) {
                $this->addErrors($key, 'required');
            }
        }
        return $this;
    }

    /**
     * check if the field is a slug
     * @param string $key
     * @return $this
     */
    public function slug(string $key): self
    {
        $value = $this->getValue($key);
        $pattern = '/^([a-z0-9-]+-?)+$/';
        if (!is_null($value) && !preg_match($pattern, $this->data[$key])) {
            $this->addErrors($key, 'slug');
        }
        return $this;
    }

    /**
     * check if the field is not empty
     * @param string ...$keys
     * @return $this
     */
    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);

            if (is_null($value) || empty($value)) {
                $this->addErrors($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param int|null $min
     * @param int|null $max
     * @return $this
     */
    public function length(string $key, ?int $min, ?int $max = null): self
    {

        $value = $this->getValue($key);
        $length = mb_strlen($value);

        if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
            $this->addErrors($key, 'betweenLength', [$min,$max]);
            return $this;
        }

        if (!is_null($min) && $length < $min) {
            $this->addErrors($key, 'minLength', [$min]);
            return $this;
        }

        if (!is_null($max) && $length > $max) {
            $this->addErrors($key, 'maxLength', [$max]);
            return $this;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $format
     * @return $this
     */
    public function datetime(string $key, string $format = "'Y-m-d H:i:s'"): self
    {

        $value = $this->getValue($key);
        $dateTime = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();

        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $dateTime === false) {
            $this->addErrors($key, 'datetime');
        }

        return $this;
    }

    /**
     * @param string $key
     * @return Validator
     */
    public function email(string $key): self
    {
        if (!filter_var($this->getValue($key), FILTER_VALIDATE_EMAIL)) {
            $this->addErrors($key, 'email');
        }
        return $this;
    }

    /**
     * @param string $key
     * @param array $extensions
     * @return $this
     */
    public function extension(string $key, array $extensions): self
    {
        /**
         * @var UploadedFileInterface $file
         */
        $file = $this->getValue($key);
        if ($file !== null && $file->getError() === UPLOAD_ERR_OK) {
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            if (!in_array($extension, $extensions)) {
                $this->addErrors($key, 'filetype', [join(',', $extensions)]);
            }
        }


        return $this;
    }

    /**
     * get all errors
     * @return string[]
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors());
    }
}
