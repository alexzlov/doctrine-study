<?php
/**
 * Расширения для класса TbButtonColumn,
 * возволяющее присваивать кнопке id со
 * значением текущего элемента из
 * data-provider'а
 */

Yii::import('booster.widgets.TbButtonColumn');

class TbIdButtonColumn extends TbButtonColumn
{
    /**
     * @var boolean нужно ли вычислять значение ID для кнопки
     */
    public $evaluateID = true;

    /**
     * @var array аттрибуты тега, которые трогать не будем
     */
    private static $prohibitedAttrs = array(
        'class',
        'data-toggle',
        'title',
    );

    /**
     * Рендерим содержимое кнопки.
     * @param integer $row номер строки
     * @param mixed $data текущий элемент из data-provider
     */
    public function renderDataCellContent($row, $data)
    {
        $tr=array();
        ob_start();
        foreach($this->buttons as $id=>$button)
        {
            if($this->evaluateID and isset($button['options']['id']))
            {
                // Одного id нам мало.
                // Вычислим все опции, это дает возможность добавлять кастомные аттрибуты к тегам.
                foreach($button['options'] as $key => $value) {
                    if (in_array($key, self::$prohibitedAttrs)) continue;  // Не трогаем запрещенные аттрибуты
                    $button['options'][$key] = $this->evaluateExpression($button['options'][$key], array('row' => $row, 'data' => $data));
                }
            }

            $this->renderButton($id,$button,$row,$data);
            $tr['{'.$id.'}']=ob_get_contents();
            ob_clean();
        }
        ob_end_clean();
        echo strtr($this->template,$tr);
    }
}