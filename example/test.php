<?php

/**
 * @name test
 * @main test\test
 * @author skymin
 * @version S1
 * @api 3.0.0
 */

namespace test;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerInteractEvent;

use skymin\dragon\api\DragonDeathEffect;

class test extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
  }
  
  public function onJoin(PlayerInteractEvent $ev){
    $player = $ev->getPlayer();
    for ($i = 0; $i < 50; $i++) {
       DragonDeathEffect::getInstance()->setEffect([$player], $player->getX(), $player->getY() +10, $player->getZ(), $player->getLevel());
    }
  }
}
