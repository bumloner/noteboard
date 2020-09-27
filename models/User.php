<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $email
 * @property int $role
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    // роли пользователей
    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Сгенерировать хеш пароля и сохранить в модель
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Сгенерировать auth key для авторизации
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(32);
    }

    /**
     * Получить всех пользователей
     */
    public static function getAll()
    {
        return self::find()->asArray()->all();
    }

    /**
     * Получить все заметки пользователя, вместе с задачами
     */
    public function getNotes()
    {
        return Note::getByUserWithTasks($this);
    }

    /**
     * Проверка, принадлежит ли заметка пользователю
     */
    public function isOwnerOfNote(Note $note)
    {
        return ($this->id === $note->user_id);
    }

    /**
     * Проверка, принадлежит ли задача пользователю
     */
    public function isOwnerOfTask(Task $task)
    {
        // получаем данные о заметке, которой принадлежит задача
        $note = \app\models\Note::getById($task->note_id);

        // проверка, принадлежит ли заметка текущему пользователю
        return ($this->isOwnerOfNote($note));
    }

    /**
     * Проверка, является ли текущий пользователь админом
     */
    public function isAdmin()
    {
        return ($this->role === self::ROLE_ADMIN);
    }
}
