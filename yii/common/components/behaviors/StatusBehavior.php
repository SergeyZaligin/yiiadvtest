<?php
namespace common\components\behaviors;
use yii\base\Behavior;
use yii\base\Model;
/**
 * Description of StatusBehavior
 *
 * @author cobweb
 */
class StatusBehavior extends Behavior
{
    
    public $statusList;

    public function events()
    {
        return [
            
        ];
    }
    
    public function getStatusList() 
    {
        return $this->statusList;
    }
    
    public function getStatusName() 
    {
        $list = $this->owner->getStatusList();
        
        // $this->status_id выбирается ключ 1 или 0
        return $list[$this->owner->status_id];
    }
}
