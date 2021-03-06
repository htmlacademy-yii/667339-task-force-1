<?php

namespace frontend\models;

use frontend\models\query\UserQuery;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $full_name
 * @property string|null $add_data
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $locality_id
 *
 * @property FavoritePerformer[] $favoritePerformers
 * @property Profile[] $profiles
 * @property Task[] $tasksAsCreator
 * @property Task[] $tasksAsPerformer
 * @property Locality $locality
 * @property UserPortfolio[] $userPortfolios
 * @property UserSpecialization[] $userSpecializations
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'full_name'], 'required'],
            [['add_data'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['locality_id'], 'integer'],
            [['email', 'password', 'full_name'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['locality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locality::className(), 'targetAttribute' => ['locality_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'full_name' => 'Full Name',
            'add_data' => 'Add Data',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'locality_id' => 'Locality ID',
        ];
    }

    /**
     * Gets query for [[FavoritePerformers]].
     *
     * @return \yii\db\ActiveQuery|FavoritePerformerQuery
     */
    public function getFavoritePerformers()
    {
        return $this->hasMany(FavoritePerformer::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery|ProfileQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasksAsPerformer()
    {
        return $this->hasMany(Task::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasksAsCreator()
    {
        return $this->hasMany(Task::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Locality]].
     *
     * @return \yii\db\ActiveQuery|LocalityQuery
     */
    public function getLocality()
    {
        return $this->hasOne(Locality::className(), ['id' => 'locality_id']);
    }

    /**
     * Gets query for [[UserPortfolios]].
     *
     * @return \yii\db\ActiveQuery|UserPortfolioQuery
     */
    public function getUserPortfolios()
    {
        return $this->hasMany(UserPortfolio::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserSpecializations]].
     *
     * @return \yii\db\ActiveQuery|UserSpecializationQuery
     */
    public function getUserSpecializations()
    {
        return $this->hasMany(UserSpecialization::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
