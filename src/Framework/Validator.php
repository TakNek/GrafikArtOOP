<?php
namespace Framework;

use Framework\Validator\ValidationError;

class Validator
{
    /**
     * Tableau des paramètres
     *
     * @var string[]
     */
    private $params;

    /**
     * Tableau des Erreurs
     *
     * @var string[]
     */
    private $errors=[];

    public function __construct(array $params)
    {
        
        $this->params = $params;
    }

    /**
     * Vérifie que les champs sont présents dans le tableau
     *
     * @param string ...$keys
     * @return self
     */
    public function required(string ...$keys) : self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if(is_null($value))
            {
                $this->addError($key,'required');
            }
        }
        return $this;
    }

    /**
     * Vérifie que le champ n'est pas vide
     *
     * @param string ...$keys
     * @return self
     */
    public function notEmpty(string ...$keys) :self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if(is_null($value) || empty($value))
            {
                $this->addError($key,'empty');
            }
        }
        return $this;
    }

    public function isValid() :bool
    {
        return empty($this->errors);
    }

    /**
     * Récupère les Erreurs
     *
     * @return ValidationError[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    public function length(string $key , ?int $min, ?int $max = null) : self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if(
            !is_null($min) && 
            !is_null($max) &&
            ($length < $min || $length > $max )
            )
        {
            $this->addError($key,'betweenLength',[$min,$max]);
            return $this;
        }

        if(
            !is_null($min) &&
            ($length < $min)
            )
        {
            $this->addError($key,'minLength',[$min]);
            return $this;
        }

        if(
            !is_null($max) &&
            ($length > $max)
            )
        {
            $this->addError($key,'maxLength',[$max]);
            return $this;
        }
        return $this;
    }

    /**
     * Vérifie que l'element est un slug
     *
     * @param string $key
     * @return self
     */
    public function slug(string $key) : self
    {
        $value = $this->getValue($key);
        $pattern = '/^([a-z0-9]+-?)+$/';
        if(!is_null($value) && !preg_match($pattern,$this->params[$key]))
        {
            $this->addError($key,'slug');
        }
        return $this;
    }

    public function dateTime(string $key,string $format = "Y-m-d H:i:s") : self
    {
        $value = $this->getValue($key);
        $date = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();
        if($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false)
        {
            $this->addError($key, 'datetime',[$format]);
        }
        return $this;
    }

    /**
     * Ajoute une Erreur
     *
     * @param string $key
     * @param string $rule
     * @param array $attributes
     * @return void
     */
    private function addError(string $key,string $rule, array $attributes = []) : void
    {
        $this->errors[$key] = new ValidationError($key,$rule,$attributes);
    }

    private function getValue(string $key)
    {
        if(array_key_exists($key,$this->params))
        {
            return $this->params[$key];
        }
        return null;
    }
}