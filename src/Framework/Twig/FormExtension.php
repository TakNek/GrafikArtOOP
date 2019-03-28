<?php
namespace Framework\Twig;



class FormExtension extends \Twig_Extension
{
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('field', [$this, 'field'], 
            [
                'is_safe' => ['html'],
                'needs_context' => true
            ],
            )
        ];
    }

    /**
     * Genère le code HTML d'un input du formulaire
     *
     * @param array $context Contexte de la vue Twig
     * @param string $key clé du champ
     * @param [type] $value Valeur du champ
     * @param string $label Label a utiliser
     * @param array $options
     * @return string Du html quoi x')
     */
    public function field(array $context, string $key, $value,?string $label= null,array $options=[]): string
    {
        $type = $options['type']  ?? 'text';
        $errors= $this->getErrorHTML($context , $key);
        $class = 'form-group';
        $value = $this->convertValue($value);
        $attributes = [
            'class' => 'form-control ' . ($options['class'] ?? ''),
            'type' => 'text',
            'name' => $key,
            'id' => $key
        ];
        if($errors)
        {
            $class .= ' has-danger';
            $attributes['class'] .= ' form-control-danger';
        }
        if ($type === 'textarea')
        {
            $input = $this->textarea($value, $attributes);
        }
        else
        {
            $input = $this->input($value, $attributes);
        }
return "
<div class=\"$class\">
<label for=\"name\">$label</label>
$input
$errors
</div>";
    }

    /**
     * Affiche l'erreur de l'input , en gros le message d'erreur après test de validation
     *
     * @param array $context
     * @param [type] $key
     * @return string
     */
    private function getErrorHTML(array $context, $key): string
    {
        $errors = $context['errors'][$key] ?? false;
        if($errors)
        {
            return "<small class=\"form-text text-muted\" >$errors</small>";
        }
            return "";
    }

    /**
     * Genère un champ de type input
     *
     * @param string|null $value
     * @param array $attributes
     * @return string en HTML
     */
    private function input(?string $value, array $attributes): string
    {
        return "<input ".$this->getHtlmFromArray($attributes)." value=\"$value\">";
    }

    /**
     * Genère un champ de type textarea
     *
     * @param string|null $value
     * @param array $attributes
     * @return string en HTML
     */
    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea ".$this->getHtlmFromArray($attributes)." >$value</textarea>";
    }

    /**
     * retroune les paramètre de la balise HTML
     *
     * @param array $attributes
     * @return string
     */
    private function getHtlmFromArray(array $attributes): string
    {
        return implode(' ', array_map(function($key,$value){
            return"$key=\"$value\"";
        },
        array_keys($attributes),$attributes));
    }

    private function convertValue($value) : string
    {
        if($value instanceof \DateTime)
        {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
}