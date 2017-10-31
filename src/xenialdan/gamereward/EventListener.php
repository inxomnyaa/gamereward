<?php

namespace xenialdan\gamereward;

use pocketmine\event\Listener;
use xenialdan\gameapi\event\RegisterGameEvent;
use xenialdan\gameapi\event\StartGameEvent;
use xenialdan\gameapi\event\StopGameEvent;
use xenialdan\gameapi\event\WinEvent;

/**
 * Class EventListener
 * @package xenialdan\gamereward
 * Listens for all normal events
 */
class EventListener implements Listener{

	public function onRegisterGame(RegisterGameEvent $event){
		Loader::getInstance()->addGame($event->getGame());
	}

	public function onStopGame(StopGameEvent $event){ }

	public function onWinGame(WinEvent $event){
		Loader::getInstance()->executeRewards($event->getGame(), $event->getWinningPlayers());
	}
}