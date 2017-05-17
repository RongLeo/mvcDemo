<?php
namespace Model;
use Framework\Core\Model;

class UserModel extends Model {
	protected $tableName = 'shop_user';
	protected $pk = 'uid';
}