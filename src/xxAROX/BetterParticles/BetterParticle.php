<?php
/* Copyright (c) 2020 xxAROX. All rights reserved. */
namespace xxAROX\BetterParticles;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\Player;
use pocketmine\Server;


/**
 * Class BetterParticle
 * @package xxAROX\BetterParticles
 * @author xxAROX
 * @date 30.06.2020 - 10:45
 * @project BetterParticles
 */
abstract class BetterParticle{
	/** @var string */
	const TYPE_ID = "";
	/** @var Vector3 */
	protected $vector3;
	/** @var null|Player[] */
	protected $players;

	/**
	 * BetterParticle constructor.
	 * @param Vector3 $vector3
	 * @param null|Player[] $players
	 */
	public function __construct(Vector3 $vector3, ?array $players=null){
		$this->vector3 = $vector3;
		$this->players = $players;
	}

	/**
	 * Function getVector3
	 * @return Vector3
	 */
	public function getVector3(): Vector3{
		return $this->vector3;
	}

	/**
	 * Function spawn
	 * @return void
	 */
	public function spawn(): void{
		$pk = new SpawnParticleEffectPacket();
		$pk->particleName = self::TYPE_ID;
		$pk->position = $this->vector3;

		if (is_array($this->players)) {
			foreach ($this->players as $player) {
				$player->sendDataPacket($pk);
			}
		} else {
			foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
				$onlinePlayer->sendDataPacket($pk);
			}
		}
	}
}
