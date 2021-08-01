<?php

/**
 * @name DragonDeathEffect
 * @main skymin\dragon\api\DragonDeathEffect
 * @author skymin
 * @version SKY
 * @api 3.0.0
 */
 
declare(strict_types = 1);

namespace skymin\dragon\api;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\{ActorEventPacket, AddActorPacket, RemoveActorPacket};

use pocketmine\level\Level;
use pocketmine\level\Position;

use pocketmine\scheduler\Task;

class DragonDeathEffect extends PluginBase{
  
  public static $instance = null;
  
  public static function getInstance() :?DragonDeathEffect{
    return self::$instance;
  }
  
  public function onLoad():void{
    self::$instance = $this;
  }
  
  public function onEnable():void{
    $this->getLogger()->alert('made by skymin');
  }
  
  public function setEffect(array $player, $x, $y, $z, Level $level):void{
    $id = Entity::$entityCount++;
    
    $pk = new AddActorPacket();
    $pk->type = 'minecraft:ender_dragon';
    $pk->entityRuntimeId = $id;
    $pk->metadata = [Entity::DATA_SCALE => [Entity::DATA_TYPE_FLOAT, 0]];
    $pk->motion = null;
    $pk->position = new Position($x, $y, $z, $level);
    Server::getInstance()->batchPackets($player, [$pk], false);
    
    $pk = new ActorEventPacket();
    $pk->entityRuntimeId = $id;
    $pk->event = ActorEventPacket::ENDER_DRAGON_DEATH;
    Server::getInstance()->batchPackets($player, [$pk], false);
    
    $pk = new RemoveActorPacket();
    $pk->entityUniqueId = $id;
    $this->getScheduler()->scheduleDelayedTask(new class($player, $pk)extends Task{
      private $player, $pk;

      public function __construct($player, $pk){
        $this->player = $player;
        $this->pk = $pk;
      }

      public function onRun($currentTick){
        Server::getInstance()->batchPackets($this->player, [$this->pk], false);
      }
    }, 120);
  }
  
}