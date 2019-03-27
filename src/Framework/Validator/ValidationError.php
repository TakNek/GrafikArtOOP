<?php
namespace Framework\Validator;

class ValidationError
{
    private $key;

    private $rule;
    
    private $attributes;

    private $messages = [
        'required' => 'le champ %s est requis',
        'slug' => 'le champ %s n\'est pas un slug valide',
        'betweenLength' => 'le champ %s doit contenir entre %d et %d caractère',
        'minLength' => 'le champ %s doit contenir plus de %d caractères',
        'maxLength' => 'le champ %s doit contenir moins de %d caractères',
        'empty' => 'le champ %s ne peut être vide',
        'datetime' => 'le champ %s doit être une date valide valide (%s)'
    ];


    public function __construct(string $key,string $rule,array $attributes = [])
    {
        
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString() 
    {
        $params = array_merge([$this->messages[$this->rule],$this->key], $this->attributes);
        return (string) call_user_func_array('sprintf',$params);
    }
}