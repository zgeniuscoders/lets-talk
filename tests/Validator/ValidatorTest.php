<?php
//
//use Legacy\Legacy\Validation\Validator;
//
//class ValidatorTest extends \PHPUnit\Framework\TestCase
//{
//    public function testRequiredIfFail()
//    {
//        $validator = new Validator([
//            'name' => 'zgenius'
//        ]);
//        $validator->required('name','content');
//        $errors = $validator->errors();
//
//        $this->assertCount(1, $errors);
//        $this->assertEquals("Le champs content est requis",$errors["content"]);
//    }
//
//    public function testRequiredIfSuccess()
//    {
//        $validator = new Validator([
//            'name' => 'zgenius',
//            'email' => 'zgeniuscoders@gmail.com'
//        ]);
//        $validator->required('name','email');
//        $errors = $validator->errors();
//
//        $this->assertCount(0, $errors);
//    }
//
//    public function testSlugSuccess()
//    {
//        $validator = new Validator([
//            'slug' => 'aze-aze-aze',
//        ]);
//        $validator->slug('slug');
//        $errors = $validator->errors();
//        $this->assertCount(0,$errors);
//    }
//
//    public function testSlugIfError()
//    {
//        $validator = new Validator([
//            'slug' => 'aze-aze-azeAze100',
//            'slug2' => 'aze-aze_azeAze100',
//            'slug3' => 'aze--_aze-aze',
//        ]);
//        $validator->slug('slug');
//        $validator->slug('slug2');
//        $validator->slug('slug3');
//        $validator->slug('slug4');
//        $errors = $validator->errors();
//        $this->assertCount(3,$errors);
//    }
//
//    public function testNotEmpty()
//    {
//        $validator = new Validator([
//            'email' => ''
//        ]);
//        $validator->notEmpty('email');
//        $error = $validator->errors();
//        $this->assertCount(1,$error);
//    }
//
//    public function testLength()
//    {
//        $validator = new Validator([
//            'password' => '123456789'
//        ]);
//        $this->assertCount(0,$validator->length('password',3)->errors());
//        $this->assertCount(1,$validator->length('password',12)->errors());
//        $this->assertCount(1,$validator->length('password',3,4)->errors());
////        $this->assertCount(0,$validator->length('password',3,20)->errors());
//    }
//
//    public function testDateTime()
//    {
//        $validator = new Validator([
//            'date' => '2022-06-08 00:00:00'
//        ]);
//        $validator2 = new Validator([
//            'date' => '2022-06-08 10:20:00'
//        ]);
//        $this->assertCount(0,$validator->datetime('date')->errors());
//        $this->assertCount(0,$validator2->datetime('date')->errors());
//
//    }
//}