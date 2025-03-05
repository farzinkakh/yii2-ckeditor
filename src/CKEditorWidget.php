<?php

namespace farzinkakh\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

class CKEditorWidget extends Widget
{
    public $model;
    public $attribute;
    public $options = [];

    public function init()
    {
        parent::init();
        $this->options['id'] = Html::getInputId($this->model, $this->attribute);
    }

    public function run()
    {
        // Register CKEditor script
        $view = $this->getView();
        $view->registerJsFile('https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js', [
            'position' => View::POS_HEAD,
        ]);

        // Initialize CKEditor
        $js = <<<JS
            ClassicEditor
                .create(document.querySelector('#{$this->options['id']}'))
                .catch(error => {
                    console.error(error);
                });
        JS;

        $view->registerJs($js, View::POS_END);

        // Render the textarea
        return Html::activeTextarea($this->model, $this->attribute, $this->options);
    }
}