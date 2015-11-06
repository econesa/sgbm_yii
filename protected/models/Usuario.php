<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property integer $rol_id
 * @property string $username
 * @property string $password
 * @property string $salt
 */
class Usuario extends CActiveRecord
{
	const ROL_REGISTERED=4, ROL_ADMIN_BM=3, ROL_ADMIN=2, ROL_SUPERADMIN=1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('rol_id, dependencia_id, username, password, salt', 'required'),
			array('username', 'unique'),
			array('rol_id, dependencia_id', 'numerical', 'integerOnly'=>true),
			array('username, password, salt', 'length', 'max'=>128),
			array('rol_id, dependencia_id, username', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'rol' => array(self::BELONGS_TO, 'Rol', 'rol_id'),
			'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rol_id' => 'Rol',
			'dependencia_id' => 'Dependencia',
			'username' => 'Usuario',
			'password' => 'Password',
			'salt' => 'Salt',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('rol_id',$this->rol_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validatePassword($password)
    {
        return $this->hashPassword($password,$this->salt)===$this->password;
    }
 
    public function hashPassword($password,$salt)
    {
        return md5($salt.$password);
    }
    
    static function getAccessLevelList( $rol = null )
    {
	  $levelList=array(
	  	self::ROL_REGISTERED => 'Usuario Registrado',
	  	self::ROL_ADMIN => 'Administrador'
	  );
	  if( $level === null)
	  	return $levelList;
	  return $levelList[ $level ];
	}
    
   static function privilegiado($rol_id = 99)
   {
	  $acceso = 0;
		if ($rol_id < self::ROL_REGISTERED) {
			$acceso = 1;
		}
		return $acceso;
	}
}
