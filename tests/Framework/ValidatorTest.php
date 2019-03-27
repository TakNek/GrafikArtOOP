<?php

namespace Tests\Framework;

use Framework\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private function makeValidator(array $params)
    {
        return new Validator($params);
    }

    public function testRequiredIfFails()
    {
        $errors = $this->makeValidator([
            'name' => 'joe'
        ])
            ->required('name','content')
            ->getErrors();
        $this->assertCount(1,$errors);
    }

    public function testNotEmpty()
    {
        $errors = $this->makeValidator([
            'name' => 'joe',
            'content' => ''
        ])
            ->notEmpty('content')
            ->getErrors();
        $this->assertCount(1,$errors);
    }

    public function testRequiredIfSuccess()
    {
        $errors = $this->makeValidator([
            'name' => 'joe',
            'content' => 'content'
        ])
            ->required('name','content')
            ->getErrors();
        $this->assertCount(0,$errors);
    }

    public function testSlugSuccess()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-zae45'
        ])
            ->slug('slug')
            ->getErrors();
        $this->assertCount(0,$errors);
    }

    public function testSlugFailed()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-zaAe45',
            'slug2' => 'aze-aze_zae45',
            'slug3' => 'aze--aze-zae45'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->getErrors();
        $this->assertCount(3,$errors);
    }

    public function testLength()
    {
        $params = ['slug' => '123456789'];
        $this->assertCount(0,$this->makeValidator($params)->length('slug',3)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',12)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',3,4)->getErrors());
        $this->assertCount(0,$this->makeValidator($params)->length('slug',3,20)->getErrors());
        $this->assertCount(0,$this->makeValidator($params)->length('slug',null,20)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',null,8)->getErrors());
    }

    public function testDatetime()
    {
        $params = ['date' => '2012-12-12 11:12:13'];
        $this->assertCount(0,$this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0,$this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1,$this->makeValidator(['date' => '2012-21-12'])->dateTime('date')->getErrors());
        $this->assertCount(1,$this->makeValidator(['date' => '2013-02-29 11:12:13'])->dateTime('date')->getErrors());
    }
}