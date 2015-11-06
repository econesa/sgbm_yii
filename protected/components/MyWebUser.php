<?php
class MyWebUser extends CWebUser
{
	private $_user;
	 
	//is the user a superadmin ?
	function getIsSuperAdmin(){
	  	return ( $this->user && $this->user->rol_id == Usuario::ROL_SUPERADMIN );
	}
	
	//is the user an administrator ?
	function getIsAdmin(){
	  	return ( $this->user && $this->user->rol_id == Usuario::ROL_ADMIN );
	}
	
	//is the user an administrator ?
	function getIsAdminBm(){
	  	return ( $this->user && $this->user->rol_id == Usuario::ROL_ADMIN_BM );
	}
	
	//is the REGISTERED user ?
	function getIsRegistered(){
	  	return ( $this->user && $this->user->rol_id == Usuario::ROL_REGISTERED );
	}
	
	//get the logged user
	function getUser(){
	  if( $this->isGuest )
	   	return;
	  if( $this->_user === null ){
	   	$this->_user = Usuario::model()->findByPk( $this->id );
	  }
	  return $this->_user;
	}
	
}