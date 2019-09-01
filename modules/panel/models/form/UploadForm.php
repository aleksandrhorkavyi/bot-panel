<?php

namespace app\modules\panel\models\form;

use app\modules\panel\models\TokenActive;
use SplFileObject;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @var array
     */
    public $saved = [];

    /**
     * @var array
     */
    public $existed = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    /**
     * @param string $token
     * @return bool
     */
    public function existedToken(string $token)
    {
        return (new Query())->from('token_active')
            ->where(['value' => $token])->exists();
    }

    /**
     * @return bool
     */
    public function saveTokens()
    {
        $file = new SplFileObject($this->file->tempName);
        $prototype = new TokenActive();

        while (!$file->eof()) {
            $token = trim($file->getCurrentLine());
            if (!empty($token)) {
                if ($this->existedToken($token)) {
                    $this->addExisted($token);
                } else {
                    $model = clone $prototype;
                    $model->value = $token;
                    $model->save();
                    $this->addSaved($token);
                }
            }
        }
        return true;
    }

    /**
     * @param $token
     */
    public function addExisted($token)
    {
        $this->existed[] = $token;
    }

    /**
     * @param $token
     */
    public function addSaved($token)
    {
        $this->saved[] = $token;
    }
}