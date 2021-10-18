<?php

namespace Tp;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;

class Tpa extends PluginBase implements Listener{

    public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("
  _____                      _       ____   __  __ 
 |_   _|  _ __     __ _     / \     / ___| |  \/  |
   | |   | '_ \   / _` |   / _ \   | |     | |\/| |
   | |   | |_) | | (_| |  / ___ \  | |___  | |  | |
   |_|   | .__/   \__,_| /_/   \_\  \____| |_|  |_|
         |_|                                       
        by fernanACM 
        ");
        $this->askerarr = [];
        $this->vktmarr = [];
        $this->vktmarrhere = [];
        $this->askerarrhere = [];
    }


    public function onQuit(PlayerQuitEvent $ev){
        $player = $ev->getPlayer();
        if(isset($this->vktmarr[strtolower($player->getLowerCaseName())])){
            unset($this->askerarr[$this->asker->getLowerCaseName()]);
            unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->askerarr[strtolower($player->getLowerCaseName())])){
            unset($this->askerarr[$this->asker->getLowerCaseName()]);
            unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->vktmarrhere[strtolower($player->getLowerCaseName())])){
            unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
            unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->askerarrhere[strtolower($player->getLowerCaseName())])){
            unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
            unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
        }
    }
        
        
        
        
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
        switch($cmd->getName()){
            case "tpa":
            if(!isset($args[0])){
                $sender->sendMessage("§3§l[§bTpaACM§3] §r§cYou must specific player");
            }else {
                $player = $this->getServer()->getPlayer($args[0]);
                if($player === null){
                    $sender->sendMessage("§3§l[§bTpaACM§3] §r§cThis player is not online");
                }else {
                    if(isset($this->vktmarr[strtolower($player->getLowerCaseName())]) or isset($this->askerarr[strtolower($player->getLowerCaseName())]) or  isset($this->vktmarrhere[strtolower($player->getLowerCaseName())]) or  isset($this->askerarrhere[strtolower($player->getLowerCaseName())])){
                
                        $sender->sendMessage("§3§l[§bTpaACM§3] §r§cThis player already have a request");
                       }else{
                    $this->asker = $sender;
                    $this->vktm = $player;
                    $player->sendMessage("§3§l[§bTpaACM§3] §r§e".$sender->getName() . " §awant teleport to you \n §l§6/tpaccept for accept §5or §c/tpadeny for deny");
                    $sender->sendMessage("§3§l[§bTpaACM§3] §r§aYour request as been send to §e". $player->getName());
                    $this->askerarr[$sender->getLowerCaseName()] = true;
                    $this->vktmarr[$player->getLowerCaseName()] = true;

                    }
                }
            }
            break;
            case "tpaccept":
            if(isset($this->vktmarr[strtolower($sender->getLowerCaseName())])){
              $this->asker->sendMessage("§3§l[§bTpaACM§3] §r§e".$sender->getName() . " §aaccept your request");
              $this->vktm->sendMessage("§3§l[§bTpaACM§3] §r§aYou have accepted a request");
              $xyz = new Vector3($this->vktm->getX(),$this->vktm->getY(),$this->vktm->getZ()); 
              $this->asker->teleport($xyz);
              unset($this->askerarr[$this->asker->getLowerCaseName()]);
              unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
            }elseif(isset($this->vktmarrhere[strtolower($sender->getLowerCaseName())])){ 
                $this->asker->sendMessage("§3§l[§bTpaACM§3] §r§e".$sender->getName() . " §aaccept your request");
                $this->vktm->sendMessage("§3§l[§bTpaACM§3] §r§aYou have accepted a request");
                $xyz = new Vector3($this->asker->getX(),$this->asker->getY(),$this->asker->getZ()); 
                $this->vktm->teleport($xyz);
                unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
                unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
            }else{
                $sender->sendMessage("§3§l[§bTpaACM§3] §r§cYou dont have request");
            }
            break;
            case "tpahere":
            if(!isset($args[0])){
                $sender->sendMessage("§3§l[§bTpaACM§3] §r§cYou must specific player");
            }else {
                $player = $this->getServer()->getPlayer($args[0]);
                if($player === null){
                    $sender->sendMessage("§3§l[§bTpaACM§3] §r§cThis player is not online");
                }else {
                    if(isset($this->vktmarr[strtolower($player->getLowerCaseName())]) or isset($this->askerarr[strtolower($player->getLowerCaseName())]) or  isset($this->askerarrhere[strtolower($player->getLowerCaseName())]) or  isset($this->vktmarrhere[strtolower($player->getLowerCaseName())])){
                
                        $sender->sendMessage("§c§lThis player already have a request");
                       }else{
                    $this->asker = $sender;
                    $this->vktm = $player;
                    $player->sendMessage("§3§l[§bTpaACM§3] §r§e".$sender->getName() . " §asent request to you to teleport to them  \n §l§6/tpaccept for accept §5or §c/tpadeny for deny");
                    $sender->sendMessage("§3§l[§bTpaACM§3] §r§aYour request as been send to §e". $player->getName());
                    $this->askerarrhere[$sender->getLowerCaseName()] = true;
                    $this->vktmarrhere[$player->getLowerCaseName()] = true;
                       }
                }
            }
            break;
            case "tpadeny":
            if(isset($this->vktmarr[strtolower($sender->getLowerCaseName())])){
                $this->asker->sendMessage("§3§l[§bTpaACM§3]§r§e".$sender->getName() . " §cdeny your request");
                $this->vktm->sendMessage("§3§l[§bTpaACM§3] §c§lYou have deny a request");
                unset($this->askerarr[$this->asker->getLowerCaseName()]);
                unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
              }elseif(isset($this->vktmarrhere[strtolower($sender->getLowerCaseName())])){ 
                  $this->asker->sendMessage("§3§l[§bTpaACM§3]§r§e".$sender->getName() . " §cdeny your request");
                  $this->vktm->sendMessage("§3§l[§bTpaACM§3] §c§lYou have deny a request");
                  unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
                  unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
              }else{
                  $sender->sendMessage("§3§l[§bTpaACM§3] §r§cYou dont have request");
              }
            break;
        }
        return true;
    }
}
