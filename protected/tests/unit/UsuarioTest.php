<?php

class UsuarioTest extends CDbTestCase
{
	public $fixtures = array(
	        'users'=>'Usuario',
	    );

	public function testCreate()
	{
		$user = new Usuario;
		$comment->setAttributes(array(
		        'id'=>'50',
		        'cedula'=>'A',
		        'nombre'=>'José',
		        'sexo_id'=>1,
		        'profesion_id'=>1,
		        'f_creacion'=>'2012-05-08 19:37:02',
				'f_cambios'=>'2012-05-08 19:37:02'
		    ),false);
		$this->assertTrue($user->save(false));
		
		// verify
		$user = Usuario::model()->findByPk($user->id);
		$this->assertTrue($user instanceof Usuario);
		$this->assertEquals(1,$user->profesion_id);
	}
	


}
